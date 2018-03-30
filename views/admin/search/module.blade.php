<div class="uk-navbar-item">
    <form method="get" action="/admin/search">
        <select name="query" class="uk-form-width-medium form-search-autocomplite">
            <option value="@yield('title_search')">@yield('title_search')</option>
        </select>
        {{ csrf_field() }}
    </form>
</div>