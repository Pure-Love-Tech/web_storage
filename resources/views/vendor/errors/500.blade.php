@extends('errors.layout')
@section('title', translate('Server Error', 'errors'))
@section('code', '500')
@section('message', translate('Server error message', 'errors'))
