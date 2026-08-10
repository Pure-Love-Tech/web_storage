<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\BlogArticle;
use App\Models\Feature;
use App\Models\Language;
use App\Models\MailTemplate;
use App\Models\Theme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class LanguageController extends Controller
{
    public $activeTheme;
    public $langPath;

    public function __construct()
    {
        $this->activeTheme = activeTheme();
        $this->langPath = base_path("lang/themes/{$this->activeTheme}");
    }

    public function index()
    {
        $languages = Language::orderBy('sort_id', 'asc')->get();
        $idsArray = implode(',', $languages->pluck('id')->toArray());
        return view('backend.settings.languages.index', [
            'idsArray' => $idsArray,
            'languages' => $languages,
        ]);
    }

    public function sort(Request $request)
    {
        if ($request->has('ids') && !is_null($request->ids)) {
            $arr = explode(',', $request->ids);
            foreach ($arr as $sortOrder => $id) {
                $menu = Language::find($id);
                $menu->sort_id = $sortOrder;
                $menu->save();
            }
        }
        toastr()->success(admin_trans('updated Successfully'));
        return back();
    }

    public function create()
    {
        return view('backend.settings.languages.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'block_patterns', 'max:150'],
            'flag' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'code' => ['required', 'string', 'max:10', 'min:2', 'unique:languages'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        if (!array_key_exists($request->code, Language::options())) {
            toastr()->error(admin_trans('Language code not exists'));
            return back();
        }

        try {
            $this->createNewLanguageFiles($request->code);
            $flag = imageUpload($request->file('flag'), 'images/languages/', null, $request->code);
            $sortId = Language::get()->count() + 1;
            $language = Language::create([
                'name' => $request->name,
                'flag' => $flag,
                'code' => $request->code,
                'sort_id' => $sortId,
            ]);
            $mailTemplates = MailTemplate::where('lang', env('DEFAULT_LANGUAGE'))->get();
            foreach ($mailTemplates as $mailTemplate) {
                $newMailTemplate = new MailTemplate();
                $newMailTemplate->lang = $language->code;
                $newMailTemplate->alias = $mailTemplate->alias;
                $newMailTemplate->name = $mailTemplate->name;
                $newMailTemplate->subject = $mailTemplate->subject;
                $newMailTemplate->body = $mailTemplate->body;
                $newMailTemplate->shortcodes = $mailTemplate->shortcodes;
                $newMailTemplate->status = $mailTemplate->status;
                $newMailTemplate->save();
            }
            if ($request->has('is_default')) {
                setEnv('DEFAULT_LANGUAGE', $language->code);
            }
            toastr()->success(admin_trans('Created Successfully'));
            return redirect()->route('admin.settings.languages.translates', $language->code);
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    private function createNewLanguageFiles($code)
    {
        try {
            $defaultLanguage = env('DEFAULT_LANGUAGE');
            $themes = Theme::all();
            foreach ($themes as $theme) {
                $themeLanguagesPath = base_path("lang/themes/{$theme->alias}");
                $themeDefaultLanguageFiles = File::allFiles("{$themeLanguagesPath}/{$defaultLanguage}");
                $themeNewLanguagePath = "{$themeLanguagesPath}/{$code}";
                if (!File::exists($themeNewLanguagePath)) {
                    File::makeDirectory($themeNewLanguagePath);
                }
                foreach ($themeDefaultLanguageFiles as $file) {
                    $filePath = "{$themeNewLanguagePath}/{$file->getFilename()}";
                    if (!File::exists($filePath)) {
                        File::copy($file, $filePath);
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function translate(Request $request, $code, $group = null)
    {
        $language = Language::where('code', $code)->firstOrFail();

        $groups = array_map(function ($file) {
            return pathinfo($file)['filename'];
        }, File::files("{$this->langPath}/{$language->code}"));

        $active = $group ?? 'general';
        $translates = trans($active, [], $language->code);

        usort($groups, function ($a, $b) {
            if (strpos($a, 'general') !== false && strpos($b, 'general') === false) {
                return -1;
            } else if (strpos($a, 'general') === false && strpos($b, 'general') !== false) {
                return 1;
            } else {
                return 0;
            }
        });

        $defaultLanguage = trans($active, [], env('DEFAULT_LANGUAGE'));

        return view('backend.settings.languages.translate', [
            'active' => $active,
            'groups' => $groups,
            'translates' => $translates,
            'language' => $language,
            'defaultLanguage' => $defaultLanguage,
        ]);
    }

    public function translateUpdate(Request $request, $id)
    {
        $language = Language::where('id', $id)->firstOrFail();

        $languageGroupFile = "{$this->langPath}/{$language->code}/{$request->group}.php";
        if (!file_exists($languageGroupFile)) {
            toastr()->error(admin_trans('Language group file not exists'));
            return back();
        }

        $translates = [];
        $translations = include $languageGroupFile;
        foreach ($request->translates as $key1 => $value1) {
            if (is_array($value1)) {
                foreach ($value1 as $key2 => $value2) {
                    if (!array_key_exists($key2, $value1)) {
                        toastr()->error(admin_trans('Translations error'));
                        return back();
                    }
                    $translates[$key1][$key2] = is_null($value2) ? '' : $value2;
                }
            } else {
                if (!array_key_exists($key1, $translations)) {
                    toastr()->error(admin_trans('Translations error'));
                    return back();
                }
                $translates[$key1] = is_null($value1) ? '' : $value1;
            }
        }

        $fileContent = "<?php \n return " . var_export($translates, true) . ";";
        File::put($languageGroupFile, $fileContent);

        toastr()->success(admin_trans('Updated Successfully'));
        return back();
    }

    public function edit(Language $language)
    {
        return view('backend.settings.languages.edit', ['language' => $language]);
    }

    public function update(Request $request, Language $language)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'block_patterns', 'max:150'],
            'flag' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        try {
            $flag = ($request->has('flag')) ? imageUpload($request->file('flag'), 'images/languages/', null, $language->code, $language->flag) : $language->flag;
            $language->update([
                'name' => $request->name,
                'flag' => $flag,
            ]);
            if ($request->has('is_default')) {
                setEnv('DEFAULT_LANGUAGE', $language->code);
            }
            toastr()->success(admin_trans('Updated Successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function destroy(Language $language)
    {
        if ($language->code == env('DEFAULT_LANGUAGE')) {
            toastr()->error(admin_trans('Default language cannot be deleted'));
            return back();
        }

        $articles = BlogArticle::where('lang', $language->code)->get();
        if ($articles->count() > 0) {
            foreach ($articles as $article) {
                removeFile(public_path($article->image));
            }
        }

        $features = Feature::where('lang', $language->code)->get();
        if ($features->count() > 0) {
            foreach ($features as $feature) {
                removeFile(public_path($feature->image));
            }
        }

        $this->deleteLanguageFiles($language->code);
        removeFile(public_path($language->flag));
        $language->delete();
        toastr()->success(admin_trans('Deleted Successfully'));
        return back();
    }

    public function deleteLanguageFiles($code)
    {
        $themes = Theme::all();
        foreach ($themes as $theme) {
            $themeLanguagesPath = base_path("lang/themes/{$theme->alias}");
            $languageDirectory = "{$themeLanguagesPath}/{$code}";
            if (File::exists($languageDirectory)) {
                File::deleteDirectory($languageDirectory);
            }
        }
    }

    public function export(Request $request, $code)
    {
        $language = Language::where('code', $code)->firstOrFail();
        if (!class_exists('ZipArchive')) {
            toastr()->error(admin_trans('ZipArchive extension is not enabled'));
            return back();
        }
        try {
            $languagePath = "{$this->langPath}/{$language->code}";
            if (!is_dir($languagePath)) {
                toastr()->error(admin_trans('Language files not exists'));
                return back();
            }
            $zip = new \ZipArchive;
            $zipFile = "{$this->activeTheme}_theme_{$language->code}_translates.zip";
            if ($zip->open($zipFile, \ZipArchive::CREATE) === true) {
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($languagePath), \RecursiveIteratorIterator::LEAVES_ONLY);
                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($languagePath) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
                $zip->close();
                return response()->download($zipFile)->deleteFileAfterSend(true);
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function import(Request $request, $code)
    {
        $language = Language::where('code', $code)->firstOrFail();
        if (!class_exists('ZipArchive')) {
            toastr()->error(admin_trans('ZipArchive extension is not enabled'));
            return back();
        }
        try {
            $file = $request->file('language_file');
            if ($file->getClientOriginalExtension() != "zip") {
                toastr()->error(admin_trans('File type not allowed'));
                return back();
            }
            $zip = new \ZipArchive;
            $res = $zip->open($file->getRealPath());
            if ($res === true) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entry = $zip->getNameIndex($i);
                    if (pathinfo($entry, PATHINFO_EXTENSION) != 'php') {
                        toastr()->error(admin_trans('Invalid language files'));
                        return back();
                    }
                }
                $langPath = "{$this->langPath}/{$language->code}";
                removeDirectory($langPath);
                makeDirectory($langPath);
                $zip->extractTo($langPath);
                $zip->close();
                toastr()->success(admin_trans('Language imported successfully'));
                return back();
            } else {
                toastr()->error(admin_trans('Failed to import language'));
                return back();
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

}
