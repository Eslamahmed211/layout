<aside id="aside">
    <ul>

        <a href="/home" style="padding: 0px;"> <img class="logo" src="{{ get_logo() }}" alt="logo" width="62"
                height="26"></a>

        <x-layout.li title="الرئيسية" class="home" path="home">
            <x-icons.home></x-icons.home>
        </x-layout.li>


        <x-layout.li title="ارقامي" class="" path="">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
            </svg>

        </x-layout.li>

        <x-layout.li title="جهات الاتصال" class="contacts" path="users/groups">
            <i class="fa-regular fa-address-book fa-fw"></i>
        </x-layout.li>



        <x-layout.li title="الرسائل" class="messages" path="users/messages">
            <x-icons.home></x-icons.home>
        </x-layout.li>

        <x-layout.li title="ارسال فوري" class="send" path="users/sent-text-message/direct">
            <i class="fa-regular fa-paper-plane fa-fw"></i>

        </x-layout.li>

        <x-layout.li title="رسائل مجدولة" class="" path="">
            <i class="fa-regular fa-clock fa-fw"></i>
        </x-layout.li>


    </ul>
</aside>
