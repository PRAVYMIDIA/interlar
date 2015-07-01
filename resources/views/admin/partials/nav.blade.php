{{-- TODO: --}}
{{--<div class="input-group">--}}
{{--<input type="text" class="form-control" placeholder="Search...">--}}
{{--<span class="input-group-btn">--}}
{{--<button class="btn btn-default" type="button">--}}
{{--<i class="fa fa-search"></i>--}}
{{--</button>--}}
{{--</span>--}}
{{--</div>--}}

<div class="metismenu">
<ul class="nav nav-pills nav-stacked">
    <li class="{{set_active('admin/dashboard')}}">
        <a href="{{url('admin/dashboard')}}">
            <i class="fa fa-dashboard fa-fw"></i>
            <span class="hidden-sm text"> Painel</span>
        </a>
    </li>
    <li class="{{set_active('admin/ambiente*')}}">
        <a href="{{url('admin/ambiente')}}">
            <i class="fa fa-home"></i>
            <span class="hidden-sm text"> Ambientes</span>
        </a>
    </li>
    <!-- <li class="{{set_active('admin/news*')}}">
        <a href="#">
            <i class="glyphicon glyphicon-bullhorn"></i> Notícias
            <span class="fa arrow"></span>
        </a>
        <ul class="nav collapse">
            <li class="{{set_active('admin/newscategory')}}">
                <a href="{{url('admin/newscategory')}}">
                    <i class="glyphicon glyphicon-list"></i>
                    <span class="hidden-sm text"> Categorias de Notícias</span>
                </a>
            </li>
            <li class="{{set_active('admin/news')}}">
                <a href="{{url('admin/news')}}">
                    <i class="glyphicon glyphicon-bullhorn"></i>
                    <span class="hidden-sm text"> Notícias</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="{{set_active('admin/photo*')}}">
        <a href="#">
            <i class="glyphicon glyphicon-camera"></i> Fotos
            <span class="fa arrow"></span>
        </a>
        <ul class="nav collapse">
            <li class="{{set_active('admin/photoalbum')}}">
                <a href="{{url('admin/photoalbum')}}">
                    <i class="glyphicon glyphicon-list"></i>
                    <span class="hidden-sm text"> Álbuns</span>
                </a>
            </li>
            <li class="{{set_active('admin/photo')}}">
                <a href="{{url('admin/photo')}}">
                    <i class="glyphicon glyphicon-camera"></i>
                    <span class="hidden-sm text"> Fotos</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="{{set_active('admin/video*')}}">
        <a href="#">
            <i class="glyphicon glyphicon-facetime-video"></i> Vídeos
            <span class="fa arrow"></span>
        </a>
        <ul class="nav collapse">
            <li class="{{set_active('admin/videoalbum')}}">
                <a href="{{url('admin/videoalbum')}}">
                    <i class="glyphicon glyphicon-list"></i>
                    <span class="hidden-sm text"> Álbuns</span>
                </a>
            </li>
            <li class="{{set_active('admin/video')}}">
                <a href="{{url('admin/video')}}">
                    <i class="glyphicon glyphicon-facetime-video"></i>
                    <span class="hidden-sm text"> Vídeos</span>
                </a>
            </li>
        </ul>
    </li> -->
    <li class="{{set_active('admin/users*')}}">
        <a href="{{url('admin/users')}}">
            <i class="glyphicon glyphicon-user"></i>
            <span class="hidden-sm text"> Usuários</span>
        </a>
    </li>
</ul>
</div>