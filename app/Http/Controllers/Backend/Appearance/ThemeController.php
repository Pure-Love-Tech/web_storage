<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Backend\AddonController;
use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Language;
use App\Models\Settings;
use App\Models\Theme;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Str;
use Validator;
use ZipArchive;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return view('backend.appearance.themes.index', ['themes' => $themes]);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_code' => ['required', 'string'],
            'theme_files' => ['required', 'mimes:zip'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        if (!class_exists('ZipArchive')) {
            toastr()->error(admin_trans('ZipArchive extension is not enabled'));
            return back();
        }

        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $request->purchase_code)) {
            if (!preg_match("/^([d-u0-9]{10})-(([d-u0-9]{5})-){3}([d-u0-9]{10})$/i", $request->purchase_code)) {
                toastr()->error(admin_trans('Invalid purchase code'));
                return back();
            }
        }

        try {

            $themeZipFile = storageFileUpload($request->file('theme_files'), 'temp/', 'local');
            $themeUploadPath = storage_path("app/{$themeZipFile}");

            $tempFolder = md5(Str::random(10) . time());
            $themeTempPath = storage_path("app/temp/{$tempFolder}");

            if (File::exists($themeTempPath)) {
                removeDirectory($themeTempPath);
            }

        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        try {

            $zip = new ZipArchive;
            $res = $zip->open($themeUploadPath);
            if ($res != true) {
                throw new Exception(admin_trans('Could not open the theme zip file'));
            }

            $res = $zip->extractTo($themeTempPath);
            if ($res == true) {
                removeFile($themeUploadPath);
            }

            $zip->close();

            $configFile = "{$themeTempPath}/config.json";
            if (!File::exists($configFile)) {
                throw new Exception(admin_trans('Theme Config is missing'));
            }

            $config = json_decode(File::get($configFile), true);

            if ($config['type'] != "theme") {
                throw new Exception(admin_trans('Invalid theme files'));
            }

            if (isInLiveServer()) {
                $response = purchaseCodeValidation($request->purchase_code, $config['item']['alias']);
                if (isset($response->status)) {
                    if ($response->status == "error") {
                        throw new Exception($response->message);
                    }
                } else {
                    throw new Exception(admin_trans('Failed to validate the purchase code'));
                }
            }

            $scriptAlias = $config['script']['alias'];
            $scriptVersion = $config['script']['version'];

            if (strtolower(config('vironeer.item.alias')) != strtolower($scriptAlias)) {
                throw new Exception(admin_trans('Invalid action request'));
            }

            if (config('vironeer.item.version') < $scriptVersion) {
                throw new Exception(admin_trans("The {$config['name']} theme require {$scriptAlias} version {$scriptVersion} or above"));
            }

            $isUpdate = $config['update'];
            $themeExists = Theme::where('alias', $config['alias'])->first();
            if (!$isUpdate) {
                if ($themeExists) {
                    throw new Exception(admin_trans("The {$config['name']} theme is already exists."));
                }
            } else {
                if (!$themeExists) {
                    throw new Exception(admin_trans("The {$config['name']} is not exists to make the update."));
                }
            }

            if (!empty($config['remove'])) {
                $removeDirectories = $config['remove']['directories'];
                if (!empty($removeDirectories)) {
                    foreach ($removeDirectories as $removeDirectory) {
                        removeDirectory(base_path($removeDirectory));
                    }
                }
                $removeFiles = $config['remove']['files'];
                if (!empty($removeFiles)) {
                    foreach ($removeFiles as $$removeFile) {
                        removeFile(base_path($removeFile));
                    }
                }
            }

            if (!empty($config['create'])) {
                $createDirectories = $config['create']['directories'];
                if (!empty($createDirectories)) {
                    foreach ($createDirectories as $createDirectory) {
                        makeDirectory(base_path($createDirectory));
                    }
                }
            }

            if (!empty($config['copy'])) {
                $copyDirectories = $config['copy']['directories'];
                if (!empty($copyDirectories)) {
                    foreach ($copyDirectories as $copyDirectory) {
                        File::copyDirectory("{$themeTempPath}/{$copyDirectory}", base_path($copyDirectory));
                    }
                }
                $copyFiles = $config['copy']['files'];
                if (!empty($copyFiles)) {
                    foreach ($copyFiles as $copyFile) {
                        File::copy("{$themeTempPath}/{$copyFile}", base_path($copyFile));
                    }
                }
            }

            if (!$isUpdate) {
                $themeLanguage = $config['language'];
                $languages = Language::where('code', '!=', $themeLanguage)->get();
                if ($languages->count() > 0) {
                    foreach ($languages as $language) {
                        $themeLanguagesPath = base_path("lang/themes/{$config['alias']}");
                        $themeDefaultLanguageFiles = File::allFiles("{$themeLanguagesPath}/{$themeLanguage}");
                        $themeNewLanguagePath = "{$themeLanguagesPath}/{$language->code}";
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
                }
            }

            if (!empty($config['database'])) {
                $databaseFiles = $config['database']['files'];
                if (!empty($databaseFiles)) {
                    foreach ($databaseFiles as $databaseFile) {
                        $databaseFile = "{$themeTempPath}/{$databaseFile}";
                        if (File::exists($databaseFile)) {
                            $unprepared = DB::unprepared(File::get($databaseFile));
                            if (!$unprepared) {
                                throw new Exception(admin_trans("Cannot unprepared the database file {$databaseFile}"));
                            }
                        }
                    }
                }
            }

            $theme = Theme::updateOrCreate(['alias' => $config['alias']], [
                'name' => $config['name'],
                'version' => $config['version'],
                'preview_image' => $config['preview_image'],
                'description' => $config['description'],
            ]);

            if ($theme) {
                removeDirectory($themeTempPath);
                $addons = Addon::all();
                foreach ($addons as $addon) {
                    app(AddonController::class)->installAddonThemeFiles(base_path($addon->path), $theme);
                }
                toastr()->success(admin_trans('Theme uploaded successfully'));
                return back();
            }

        } catch (Exception $e) {
            removeFile($themeUploadPath);
            removeDirectory($themeTempPath);
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function makeActive(Request $request, Theme $theme)
    {
        setEnv('DEFAULT_THEME', $theme->alias);
        Artisan::call('optimize:clear');
        toastr()->success(admin_trans('Theme has been changed Successfully'));
        return back();
    }

    public function showSettings(Request $request, Theme $theme, $group = 'general')
    {
        $themeSettingsFile = resource_path("views/themes/{$theme->alias}/settings.json");
        if (!File::exists($themeSettingsFile)) {
            die(admin_trans('Settings file is missing'));
        }

        $themeSettings = json_decode(File::get($themeSettingsFile));

        abort_if(!isset($themeSettings->$group), 404);

        $themeSettingsGroups = collect($themeSettings)->keys();
        $themeSettingsCollection = collect($themeSettings->$group);

        // $keyValue = [];
        // foreach ($themeSettingsCollection as $key => $value) {
        //     $keyValue[$value->key] = $value->value;
        // }

        // Settings::create([
        //     'key' => 'media',
        //     'value' => $keyValue,
        // ]);

        // return $keyValue;

        return view('backend.appearance.themes.settings', [
            'theme' => $theme,
            'activeGroup' => $group,
            'themeSettingsGroups' => $themeSettingsGroups,
            'themeSettingsCollection' => $themeSettingsCollection,
        ]);
    }

    public function updateSettings(Request $request, Theme $theme, $group = 'general')
    {
        $themeSettingsFile = resource_path("views/themes/{$theme->alias}/settings.json");
        if (!File::exists($themeSettingsFile)) {
            die(admin_trans('Settings file is missing'));
        }

        $themeSettings = json_decode(File::get($themeSettingsFile));
        abort_if(!isset($themeSettings->$group), 404);

        try {

            $validationRules = [];
            $settingKeys = [];
            foreach ($themeSettings->$group as $setting) {
                if (isset($setting->key, $setting->rule)) {
                    $validationRules[$setting->key] = $setting->rule;
                    $settingKeys[] = $setting->key;
                }
            }

            $requestData = $request->only($settingKeys);
            $validator = Validator::make($requestData, $validationRules);
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    toastr()->error($error);
                }
                return back();
            }

            foreach ($themeSettings->$group as $setting) {
                if (in_array($setting->field, ['checkbox', 'toggle'])) {
                    $requestData[$setting->key] = $request->has($setting->key) ? 1 : 0;
                } elseif (in_array($setting->field, ['select', 'bootstrap-select', 'radios'])) {
                    if (!array_key_exists($request->input($setting->key), (array) $setting->options)) {
                        toastr()->error(admin_trans('Failed to update ') . ' ' . $setting->label);
                        return back();
                    }
                } elseif ($setting->field == "image") {
                    if ($request->has($setting->key)) {
                        $size = isset($setting->size) && $setting->size != null ? $setting->size : null;
                        $name = isset($setting->name) && $setting->name != null ? $setting->name : null;
                        $requestData[$setting->key] = imageUpload($request->file($setting->key), "themes/{$theme->alias}/{$setting->path}", $size, $name, $setting->value);
                    }
                }
            }

            foreach ($themeSettings->$group as &$setting) {
                if (isset($setting->key)) {
                    if (array_key_exists($setting->key, $requestData)) {
                        $setting->value = $requestData[$setting->key];
                    }
                }
            }

            File::put($themeSettingsFile, json_encode($themeSettings, JSON_PRETTY_PRINT));
            $this->updateThemeColors($theme, $themeSettings->colors);

            toastr()->success(admin_trans('Updated Successfully'));
            return back();

        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function updateThemeColors($theme, $themeColors)
    {
        $output = ':root {' . PHP_EOL;
        foreach ($themeColors as &$color) {
            $output .= '  --' . $color->key . ': ' . $color->value . ';' . PHP_EOL;
        }
        $output .= '}' . PHP_EOL;
        $colorsPath = config('theme.style.colors');
        $colorsFile = public_path("themes/{$theme->alias}/{$colorsPath}");
        return File::put($colorsFile, $output);
    }

    public function showCustomCss(Theme $theme)
    {
        $customCssPath = config('theme.style.custom_css');
        $customCssFile = public_path("themes/{$theme->alias}/{$customCssPath}");
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }
        $themeCustomCssFile = File::get($customCssFile);
        return view('backend.appearance.themes.custom-css', [
            'theme' => $theme,
            'themeCustomCssFile' => $themeCustomCssFile,
        ]);
    }

    public function updateCustomCss(Request $request, Theme $theme)
    {
        $customCssPath = config('theme.style.custom_css');
        $customCssFile = public_path("themes/{$theme->alias}/{$customCssPath}");
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }
        File::put($customCssFile, $request->custom_css);
        toastr()->success(admin_trans('Updated Successfully'));
        return back();
    }
}