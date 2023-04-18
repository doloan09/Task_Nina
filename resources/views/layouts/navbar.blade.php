<div style="height: 70px; background-color: #eea236; padding-top: 10px; color: white; padding-right: 10px; position: fixed; top: 0; width: 85%; z-index: 10;">
    <div class="col-md-6" style="padding-top: 10px; font-size: 25px; ">
        <p>TRƯỜNG ĐẠI HỌC GTVT</p>
    </div>
    <div style="padding: 10px 0; display: flex; justify-content: right;" class="col-md-6">
        <p style="margin: 0 10px;">{{ isset(\Illuminate\Support\Facades\Auth::user()['email']) ? \Illuminate\Support\Facades\Auth::user()['email'] : ''}}</p>
        <div style="width: 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#fff" style="width: 20px; height: 20px">
                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/>
            </svg>
        </div>
        <div style="width: 20px; margin: 0 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#fff">
                <path d="M224 0c-17.7 0-32 14.3-32 32V49.9C119.5 61.4 64 124.2 64 200v33.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416H424c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4V200c0-75.8-55.5-138.6-128-150.1V32c0-17.7-14.3-32-32-32zm0 96h8c57.4 0 104 46.6 104 104v33.4c0 47.9 13.9 94.6 39.7 134.6H72.3C98.1 328 112 281.3 112 233.4V200c0-57.4 46.6-104 104-104h8zm64 352H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/>
            </svg>
        </div>
    </div>
</div>
