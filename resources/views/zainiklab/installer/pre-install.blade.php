@extends('zainiklab.installer.layout')

@section('title', 'Home')

@section('content')
<div class="section-wrap-body">
    <div class="single-section">
        <h4>{{__('For Manual Installation: ')}}<a href="{{route('manual_installed')}}" class="btn btn-inst rounded">{{__('Click Here')}}</a></h4>
    </div>
    <div class="single-section">
        <h4 class="section-title">{{__('Please configure your PHP settings to match following requirements')}}</h4>
        <div class="primary-table">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">{{__('PHP Settings')}}</th>
                        <th scope="col">{{__('Current Version')}}</th>
                        <th scope="col">{{__('Required Version')}}</th>
                        <th scope="col">{{__('Status')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{__('PHP Version')}}</td>
                        <td><strong>{{ __('phpversion()') }}</strong></td>
                        <td><strong>7.2+</strong></td>
                        <td><span class="status {{ phpversion() < 7.2 ? 'error' : '' }}">{{ phpversion() < 7.2 ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="single-section">
        <h4 class="section-title">{{__('Please make sure the extension/settings listed below are installed/enabled')}}</h4>
        <div class="primary-table">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">{{__('Extensions/Settings')}}</th>
                        <th scope="col">{{__('Current Settings')}}</th>
                        <th scope="col">{{__('Required Settings')}}</th>
                        <th scope="col">{{__('Status')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{__('MySQLi')}}</td>
                        <td><strong>{{ !extension_loaded('mysqli') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('mysqli') ? 'error' : '' }}">{{ !extension_loaded('mysqli') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('GD')}}</td>
                        <td><strong>{{ !extension_loaded('gd') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('gd') ? 'error' : '' }}">{{ !extension_loaded('gd') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('cURL')}}</td>
                        <td><strong>{{ function_exists('curl_version') ? __('On') : __('Off') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ function_exists('curl_version') ? '' : 'error' }}">{{ function_exists('curl_version') ? __('Ok') : __('Error') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('allow_url_fopen')}}</td>
                        <td><strong>{{ ini_get('allow_url_fopen') ? __('On') : __('Off') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ ini_get('allow_url_fopen') ? '' : 'error' }}">{{ ini_get('allow_url_fopen') ? __('Ok') : __('Error') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('OpenSSL PHP Extension')}}</td>
                        <td><strong>{{ !extension_loaded('openssl') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('openssl') ? 'error' : '' }}">{{ !extension_loaded('openssl') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('PDO PHP Extension')}}</td>
                        <td><strong>{{ !extension_loaded('pdo') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('pdo') ? 'error' : '' }}">{{ !extension_loaded('pdo') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('BCMAth PHP Extension')}}</td>
                        <td><strong>{{ !extension_loaded('bcmath') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('bcmath') ? 'error' : '' }}">{{ !extension_loaded('bcmath') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('Ctype PHP Extension')}}</td>
                        <td><strong>{{ !extension_loaded('ctype') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('ctype') ? 'error' : '' }}">{{ !extension_loaded('ctype') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('Fileinfo PHP Extension')}}</td>
                        <td><strong>{{ !extension_loaded('fileinfo') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('fileinfo') ? 'error' : '' }}">{{ !extension_loaded('fileinfo') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('MBstring PHP Extension')}}</td>
                        <td><strong>{{ !extension_loaded('mbstring') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('mbstring') ? 'error' : '' }}">{{ !extension_loaded('mbstring') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('Tokenizer PHP Extension')}}</td>
                        <td><strong>{{ !extension_loaded('tokenizer') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('tokenizer') ? 'error' : '' }}">{{ !extension_loaded('tokenizer') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('XML PHP Extension')}}</td>
                        <td><strong>{{ !extension_loaded('xml') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('xml') ? 'error' : '' }}">{{ !extension_loaded('xml') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                      <tr>
                        <td>{{__('Json PHP Extension')}}</td>
                        <td><strong>{{ !extension_loaded('json') ? __('Off') : __('On') }}</strong></td>
                        <td><strong>{{__('On')}}</strong></td>
                        <td><span class="status {{ !extension_loaded('json') ? 'error' : '' }}">{{ !extension_loaded('json') ? __('Error') : __('Ok') }}</span></td>
                      </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="single-section">
        <h4 class="section-title">{{__('Please make sure you have set the Writable permission on the following folders/files
            :')}}</h4>
        <ul class="permission-lsit">
            <li>
                <span class="permission-text">{{__('./routes')}}</span>
                <span class="status {{ File::exists(base_path('routes')) && $route_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('routes')) && $route_value == 1 ? __('Ok') : __('Error') }}</span>
            </li>
            <li>
                <span class="permission-text">{{__('./resources')}}</span>
                <span class="status {{ File::exists(base_path('resources')) && $resource_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('resources')) && $resource_value == 1 ? __('Ok') : __('Error') }}</span>
            </li>
            <li>
                <span class="permission-text">{{__('./public')}}</span>
                <span class="status {{ File::exists(base_path('public')) && $public_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('public')) && $public_value == 1 ? __('Ok') : __('Error') }}</span>
            </li>
            <li>
                <span class="permission-text">{{__('./storage')}}</span>
                <span class="status {{ File::exists(base_path('storage')) && $storage_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('storage')) && $storage_value == 1 ? __('Ok') : __('Error') }}</span>
            </li>
            <li>
                <span class="permission-text">{{__('.env')}}</span>
                <span class="status {{ File::exists(base_path('.env')) && $env_value == 1 ? '' : 'error' }}">{{ File::exists(base_path('.env')) && $env_value == 1 ? __('Ok') : __('Error') }}</span>
            </li>
        </ul>
    </div>
    <div>
        <div class="row">
            <div class="col-6">
                <button class="primary-btn">{{__('Close')}}</button>
            </div>
            <div class="col-6">
                <form action="{{ route('ZaiInstaller::server-validation') }}" method="post">
                    @csrf
                    <input type="hidden" name="routes" value="{{ File::exists(base_path('routes')) && $route_value == 1 ? 1 : 0 }}">
                    <input type="hidden" name="resources" value="{{ File::exists(base_path('resources')) && $resource_value == 1 ? 1 : 0 }}">
                    <input type="hidden" name="public" value="{{ File::exists(base_path('public')) && $public_value == 1 ? 1 : 0 }}">
                    <input type="hidden" name="storage" value="{{ File::exists(base_path('storage')) && $storage_value == 1 ? 1 : 0 }}">
                    <input type="hidden" name="env" value="{{ File::exists(base_path('.env')) && $env_value == 1 ? 1 : 0 }}">
                    <button class="primary-btn next" type="submit">{{__('Next')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
