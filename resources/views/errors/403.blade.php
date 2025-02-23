@extends('errors::minimal')

@section('title', 'Dilarang')
@section('code', '403')
@section('message', $exception->getMessage() ?: 'Akses Ditolak: Izin Tidak Memadai.')
@section('image', 'img/background/403.png')
@section('image-dark', 'img/background/403.png')
