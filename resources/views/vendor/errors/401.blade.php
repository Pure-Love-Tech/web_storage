@extends('errors.layout')
@section('title', translate('Unauthorized', 'errors'))
@section('code', '401')
@section('message', translate('Unauthorized error message', 'errors'))
