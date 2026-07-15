<!-- App Bottom Menu -->
<style>
    .appBottomMenu {
        background: #ffffff;
        border-top: 1px solid #f3f4f6;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.02);
        height: 65px;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 9999;
        padding-bottom: env(safe-area-inset-bottom);
    }

    .appBottomMenu .item {
        flex: 1;
        text-align: center;
        color: #6b7280;
        text-decoration: none;
        padding: 5px 0;
        transition: all 0.2s ease-in-out;
    }

    .appBottomMenu .item.active {
        color: #3B82F6;
    }

    .appBottomMenu .item .col {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .appBottomMenu .item ion-icon {
        font-size: 24px;
        margin-bottom: 2px;
    }

    .appBottomMenu .item strong {
        font-size: 0.65rem;
        font-weight: 500;
        display: block;
    }

    .appBottomMenu .action-button.large {
        background: #3B82F6;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-top: -30px;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.4);
        border: 4px solid #ffffff;
    }

    .appBottomMenu .action-button.large ion-icon {
        font-size: 30px;
        margin-bottom: 0;
    }
</style>
<div class="appBottomMenu">
    <a href="/dashboard" class="item {{ Request::is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="{{ Request::is('dashboard') ? 'home' : 'home-outline' }}"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="/presensi/histori" class="item {{ Request::is('presensi/histori') ? 'active' : '' }}">
        <div class="col">
            <ion-icon
                name="{{ Request::is('presensi/histori') ? 'document-text' : 'document-text-outline' }}"></ion-icon>
            <strong>Histori</strong>
        </div>
    </a>
    <a href="/presensi/create" class="item {{ Request::is('presensi/create') ? 'active' : '' }}">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera"></ion-icon>
            </div>
        </div>
    </a>
    <a href="/presensi/izin" class="item {{ Request::is('presensi/izin') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="{{ Request::is('presensi/izin') ? 'calendar' : 'calendar-outline' }}"></ion-icon>
            <strong>Cuti</strong>
        </div>
    </a>
    <a href="/editprofile" class="item {{ Request::is('editprofile') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="{{ Request::is('editprofile') ? 'people' : 'people-outline' }}"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->