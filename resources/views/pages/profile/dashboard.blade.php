<x-authenticated-layout>
    <x-slot:style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" integrity="sha512-UtLOu9C7NuThQhuXXrGwx9Jb/z9zPQJctuAgNUBK3Z6kkSYT9wJ+2+dh6klS+TDBCV9kNPBbAxbVD+vCcfGPaA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            body {
                font-size: .875rem;
            }

            .feather {
                width: 16px;
                height: 16px;
                vertical-align: text-bottom;
            }

            /*
             * Sidebar
             */

            .sidebar {
                position: fixed;
                top: 0;
                /* rtl:raw:
                right: 0;
                */
                bottom: 0;
                /* rtl:remove */
                left: 0;
                z-index: 100; /* Behind the navbar */
                padding: 48px 0 0; /* Height of navbar */
                box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            }

            @media (max-width: 767.98px) {
                .sidebar {
                    top: 5rem;
                }
            }

            .sidebar-sticky {
                position: relative;
                top: 0;
                height: calc(100vh - 48px);
                padding-top: .5rem;
                overflow-x: hidden;
                overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
            }

            .sidebar .nav-link {
                font-weight: 500;
                color: #333;
            }

            .sidebar .nav-link .feather {
                margin-right: 4px;
                color: #727272;
            }

            .sidebar .nav-link.active {
                color: #2470dc;
            }

            .sidebar .nav-link:hover .feather,
            .sidebar .nav-link.active .feather {
                color: inherit;
            }

            .sidebar-heading {
                font-size: .75rem;
                text-transform: uppercase;
            }

            /*
             * Navbar
             */

            .navbar-brand {
                padding-top: .75rem;
                padding-bottom: .75rem;
                font-size: 1rem;
                background-color: rgba(0, 0, 0, .25);
                box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
            }

            .navbar .navbar-toggler {
                top: .25rem;
                right: 1rem;
            }

            .navbar .form-control {
                padding: .75rem 1rem;
                border-width: 0;
                border-radius: 0;
            }

            .form-control-dark {
                color: #fff;
                background-color: rgba(255, 255, 255, .1);
                border-color: rgba(255, 255, 255, .1);
            }

            .form-control-dark:focus {
                border-color: transparent;
                box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
            }

            img {
                display: block;
                max-width: 100%;
            }
            .preview {
                overflow: hidden;
                width: 160px;
                height: 160px;
                margin: 10px;
                border: 1px solid red;
            }
            .modal-lg{
                max-width: 1000px !important;
            }
        </style>
    </x-slot:style>
    <x-dashboard-header></x-dashboard-header>
    <x-dashboard-menu></x-dashboard-menu>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
        <div class="row">
            <div class="col-md-6">
                @session('success')
                <x-alert class="mt-3" type="success" :message="$value"></x-alert>
                @endsession
                <h2 class="mt-4">Profile</h2>
                <div class="accordion my-5" id="accordionPanels">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsCollapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                Personal info
                            </button>
                        </h2>
                        <div id="panelsCollapseOne" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <h3>Profile picture</h3>
                                @if (!is_null($user->avatar))
                                    <img src="{{Storage::url($user->avatar)}}" class="img-thumbnail rounded" width="160" alt="profile picture">

                                    <form action="{{route('profile.delete-avatar')}}" method="POST">
                                        @session('messageAvatar')
                                        <x-alert type="success" :message="$value" class="mt-2"></x-alert>
                                        @endsession
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm my-3 d-flex align-items-center"><i class="bi bi-exclamation-circle me-1"></i> Delete profile picture</button>
                                    </form>
                                @else
                                    <img src="https://via.placeholder.com/160" class="img-thumbnail rounded" alt="placeholder">
                                @endif

                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Choose profile picture</label>
                                    <input class="image form-control" type="file" name="image" id="formFile">
                                </div>

                                <form action="{{route('profile.update')}}" method="POST">
                                    @csrf
                                    @session('message')
                                        <x-alert type="success" :message="$value"></x-alert>
                                    @endsession

                                    <h3>Base info</h3>
                                    <div class="form-group mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input id="first_name" type="text" name="first_name" class="form-control" value="{{Auth::user()->first_name}}" autocomplete="given-name" placeholder="">
                                        @error('first_name') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="last_name" class="form-label">Last name</label>
                                        <input id="last_name" type="text" name="last_name" class="form-control" value="{{Auth::user()->last_name}}" autocomplete="family-name" placeholder="">
                                        @error('last_name') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input id="email" type="text" name="email" class="form-control" value="{{Auth::user()->email}}" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="home_tel" class="form-label">Phone number (home)</label>
                                        <input id="home_tel" type="tel" name="home_tel" class="form-control" value="{{Auth::user()->home_tel ?? old('tel')}}" autocomplete="tel" placeholder="">
                                        @error('home_tel') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="work_tel" class="form-label">Phone number (work)</label>
                                        <input id="work_tel" type="tel" name="work_tel" class="form-control" value="{{Auth::user()->work_tel ?? old('tel2')}}" autocomplete="tel" placeholder="">
                                        @error('work_tel') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="website" class="form-label">Website</label>
                                        <input id="website" type="text" name="website" class="form-control" value="{{Auth::user()->website ?? old('website')}}" autocomplete="" placeholder="">
                                        @error('website') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="company" class="form-label">Company</label>
                                        <input id="company" type="text" name="company" class="form-control" value="{{Auth::user()->company ?? old('company')}}" autocomplete="organization" placeholder="">
                                        @error('company') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="job_title" class="form-label">Job title</label>
                                        <input id="job_title" type="text" name="job_title" class="form-control" value="{{Auth::user()->job_title ?? old('job_title')}}" autocomplete="organization-title" placeholder="">
                                        @error('job_title') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                                <form action="{{route('profile.update-address')}}" method="POST">
                                    @csrf
                                    @session('messageAddress')
                                    <x-alert type="success" :message="$value"></x-alert>
                                    @endsession

                                    <h3>Address info</h3>
                                    <div class="form-group mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input id="country" type="text" name="country" class="form-control" value="{{$user->location->country ?? old('country')}}" autocomplete="country" placeholder="">
                                        @error('country') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input id="city" type="text" name="city" class="form-control" value="{{$user->location->city ?? old('city')}}" autocomplete="address-level2" placeholder="">
                                        @error('city') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="street" class="form-label">Street</label>
                                        <input id="street" type="text" name="street" class="form-control" value="{{$user->location->street ?? old('street')}}" autocomplete="street-address" placeholder="">
                                        @error('street') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="postcode" class="form-label">Postal Code</label>
                                        <input id="postcode" type="text" name="postcode" class="form-control" value="{{$user->location->postcode ?? old('postcode')}}" autocomplete="postal-code" placeholder="">
                                        @error('postcode') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsCollapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                Social links
                            </button>
                        </h2>
                        <div id="panelsCollapseTwo" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <form action="{{route('profile.update-social-links')}}" method="POST">
                                    <h3 class="mb-3">Your social links</h3>
                                    @csrf
                                    @session('messageSocLink')
                                    <x-alert type="success" :message="$value"></x-alert>
                                    @endsession

                                    @foreach($socialNetworks as $network)
                                        <div class="input-group mb-3 align-items-center">
                                            <span class="input-group-text">{{$network->url_pattern}}</span>
                                            <input
                                                id="{{$network->name}}"
                                                type="text"
                                                name="{{$network->name}}"
                                                class="form-control"
                                                value="{{$user->socialNetworks[$loop->index]->pivot->link ?? ''}}"
                                                placeholder="username"
                                            >

                                            <div class="form-check ms-2">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                        {{$user->socialNetworks[$loop->index]->pivot->hidden ? 'checked' : ''}}
                                                    name="{{$network->name}}_hidden"
                                                    id="{{$network->name}}_hidden"
                                                >
                                                <label class="form-check-label" for="{{$network->name}}_hidden">
                                                    Hide
                                                </label>
                                            </div>
                                            @error($network->name) <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    @endforeach

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ms-auto">
                <x-dashboard-sidebar class="sticky-top">
                    <div class="card mx-auto " style="width: 18rem;">
                        <img src="{{$qr}}" alt="qr code">
                        <div class="card-body">
                            <h5 class="card-title">Your personal QR code</h5>
                            <p class="card-text">
                                Give your friend a QR code so they can visit your card<br>
                                Your personal card can be found here: <a href="{{$uniqueLink}}" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" target="_blank">{{$uniqueLink}}</a>
                            </p>
                            <a href="{{route('user.vcard.download', Auth::user()->user_hash)}}" class="btn btn-primary d-iflex align-items-center"><i class="bi bi-download me-1"></i> Download vcard</a>
                            <a href="{{route('profile.generate-card')}}" class="btn btn-info mt-2 d-iflex align-items-center"><i class="bi bi-arrow-clockwise me-1"></i> Manually generate a card</a>
                            <p class="small mt-1"><em>Your card is generated automatically after you update your data. But, if something gets wrong you always can regenerate it manually.</em></p>
                            @session('messageCard')
                                <p class="text-success">{{$value}}</p>
                            @endsession
                        </div>
                    </div>
                </x-dashboard-sidebar>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop Image Before Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="https://avatars0.githubusercontent.com/u/3456749" alt="user profile picture">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary d-flex align-items-center" id="crop">
                        <div class="spinner-border text-light me-1 spinner-border-sm" style="display: none; transition: all .3s ease" role="status">
                            <span class="sr-only"></span>
                        </div>
                        Crop and upload</button>
                </div>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js" integrity="sha512-JyCZjCOZoyeQZSd5+YEAcFgz2fowJ1F1hyJOXgtKu4llIa0KneLcidn5bwfutiehUTiOuK87A986BZJMko0eWQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            const $modal = $('#modal');
            const image = document.getElementById('image');
            let cropper;

            $("body").on("change", ".image", function(e){
                const files = e.target.files;
                const done = function (url) {
                    image.src = url;
                    $modal.modal('show');
                };

                let reader;
                let file;
                let url;

                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.bs.modal', function () {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                    dragMode: 'move',
                    preview: '.preview'
                });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            $("#crop").click(function(){
                const canvas = cropper.getCroppedCanvas({
                    width: 500,
                    height: 500,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });

                canvas.toBlob(function(blob) {
                    const url = URL.createObjectURL(blob);
                    const reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        const base64data = reader.result;

                        $('.spinner-border').show();

                        $.ajax({
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                            dataType: "json",
                            url: "{{route('profile.upload-avatar')}}",
                            data: {image: base64data},
                            success: function(data){
                                location.reload()
                                console.log(base64data)
                                $('.spinner-border').hide();

                            },
                            error: function (data){
                                const response = data.responseJSON.message
                                alert(response)
                                $('.spinner-border').hide();

                            }
                        });
                    }
                } ,'image/png', 1);
            })
        </script>
    </x-slot:scripts>

</x-authenticated-layout>
