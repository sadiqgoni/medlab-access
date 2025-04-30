@extends('layouts.app')

@section('content')
<!-- Profile Edit Page -->
<div class="bg-neutral-light min-h-screen pt-20 pb-12">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        <a href="{{ route('consumer.dashboard') }}" class="mr-2 bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors">
                            <i class="fas fa-arrow-left text-white"></i>
                        </a>
                        <div>
