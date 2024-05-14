@extends('admin.layout')


@section('title')
    <title>اعدادات الحساب</title>
@endsection



@section('content')
    <div class="w-100 row m-auto p-4">
        <div class="col-lg-3 p-lg-1 p-0">

            <nav class="profile_nav">

                <div class="nav nav-tabs" id="nav-tab" role="tablist">

                    <x-tab class="active" name="info" title="المعلومات الاساسية">
                        <svg width="22"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                    </x-tab>


                    <x-tab name="password" title="تغير كلمة السر">
                        <svg width="22" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/>
                        </svg>
                    </x-tab>


                </div>
            </nav>
        </div>

        <div class="col-lg-9  p-lg-1 p-0 mb-5">
            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab"
                     tabindex="0">
                    <div class="tab_content p-3">

                        <form class="row" action="{{ url('/profile/info') }}" method="post"
                              enctype="multipart/form-data">

                            @csrf
                            @method('put')


                            <x-form.input reqiured value="{{ auth()->user()->name }}" col="col-lg-6 col-12"
                                          label="اسمك ثنائي"
                                          name="name"></x-form.input>

                            <x-form.input disabled value="{{ auth()->user()->email }}" col="col-lg-6 col-12"
                                          label="البريد الالكتروني"
                                          name="email"></x-form.input>




                            <x-form.input type="file" col="col-lg-6 col-12" label="صورة الحساب"
                                          name="img"></x-form.input>


                            <div class="d-flex justify-content-end">

                                <x-form.link target="_self" class="es-btn-primary" title="ازالة صورة الحساب"
                                             path="profile/delete_img"></x-form.link>

                            </div>


                            <x-form.button id="submitBtn" title="تعديل"></x-form.button>

                        </form>

                    </div>
                </div>

                <div class="tab-pane fade show " id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab"
                     tabindex="0">
                    <div class="tab_content p-3">
                        <form class="row" action="{{ url('/profile/password') }}" method="post">

                            @csrf
                            @method('put')


                            <x-form.input reqiured col="col-lg-6 col-12" label=" كلمة السر القديمة" name="passwordOld"></x-form.input>

                            <x-form.input reqiured type="password"  col="col-lg-6 col-12" label="كلمة السر الجديدة" name="password"></x-form.input>

                            <x-form.input reqiured type="password"  col="col-lg-6 col-12" label="تأكيد كلمة السر الجديدة" name="password_confirmation"></x-form.input>

                            <x-form.button id="submitBtn" title="تغير كلمة السر"></x-form.button>

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection


@section("js")

    <script>

        document.addEventListener("DOMContentLoaded", function() {
            // Read the URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get("tab");

            // Function to remove active class from other tabs
            function removeActiveFromTabs() {
                const tabs = document.querySelectorAll(".nav-link");
                const tabContents = document.querySelectorAll(".tab-pane");
                tabs.forEach((tab) => {
                    tab.classList.remove("active");
                    tab.setAttribute("aria-selected", "false");
                });
                tabContents.forEach((tabContent) => {
                    tabContent.classList.remove("show", "active");
                });
            }

            // Activate the tab based on the URL parameter
            if (activeTab === "nav-info" || activeTab === "") {
                removeActiveFromTabs(); // Remove active class from other tabs
                const navImgsTab = document.getElementById("nav-info-tab");
                const navImgsTabContent = document.getElementById("nav-info");
                navImgsTab.classList.add("active");
                navImgsTab.setAttribute("aria-selected", "true");
                navImgsTabContent.classList.add("show", "active");
            } else if (activeTab === "nav-password") {
                removeActiveFromTabs(); // Remove active class from other tabs
                const navImgsTab = document.getElementById("nav-password-tab");
                const navImgsTabContent = document.getElementById("nav-password");
                navImgsTab.classList.add("active");
                navImgsTab.setAttribute("aria-selected", "true");
                navImgsTabContent.classList.add("show", "active");

            }

        });

        function change(tab) {
            const urlWithoutTab = window.location.href.split("?")[0];
            const newUrl = urlWithoutTab + `?tab=${tab}`;
            window.history.replaceState({}, "", newUrl);
        }


    </script>

@endsection