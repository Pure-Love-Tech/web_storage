@extends('errors.layout')
@section('title', translate('Too Many Requests', 'errors'))
@section('code', '429')
@section('message', translate('Too many requests error message', 'errors'))
