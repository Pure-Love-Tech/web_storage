@extends('errors.layout')
@section('title', translate('Forbidden', 'errors'))
@section('code', '403')
@section('message', translate('Forbidden error message', 'errors'))
