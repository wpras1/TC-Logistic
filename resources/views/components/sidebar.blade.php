@extends('layouts.app')

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-icon rotate-n-15">
                <img class="img-profile rounded-circle" src="{{ asset('img/favicon-tripaconsult.jpeg') }}" width="40px">
            </div>
            <div class="sidebar-brand-text mx-3">Tech-Logistich</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Data Input
        </div>

        <!-- Nav Item - Incoming Goods -->
        <li class="nav-item {{ Request::is('incoming-goods*') ? 'active' : '' }}">
            <a class="nav-link" href="/incoming-goods">
                <i class="fas fa-fw fa fa-download"></i>
                <span>Incoming Goods</span>
            </a>
        </li>

        <!-- Nav Item - Outcoming Goods -->
        <li class="nav-item {{ Request::is('outcoming-goods*') ? 'active' : '' }}">
            <a class="nav-link" href="/outcoming-goods">
                <i class="fas fa-fw fa fa-upload"></i>
                <span>Outgoing Goods</span>
            </a>
        </li>
        

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Warehouse -->
        <li class="nav-item {{ Request::is('warehouse*') ? 'active' : '' }}">
            <a class="nav-link" href="/warehouse">
                <i class="fas fa-warehouse"></i>
                <span>Warehouse</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

    </ul>
    <!-- End of Sidebar -->
</div>