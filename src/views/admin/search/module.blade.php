<div class="uk-navbar-item">
    <form method="get" action="/admin/search">
        <select name="query" class="uk-form-width-medium form-search-autocomplite">
            <option value="@yield('title_search')">@yield('title_search')</option>
        </select>
        {{ csrf_field() }}
    </form>
</div>

@if(isset($search_data))
    <script type="text/javascript">
        $('.form-search-autocomplite').selectize({
            maxItems: 1,
            valueField: 'full_url',
            labelField: 'title',
            searchField: 'title',
            persist: true,
            createOnBlur: false,
            create: false,
            allowEmptyOption: true,
            /*sortField: {
                field: 'title',
                direction: 'asc'
            },*/
            placeholder: 'Поиск по сайту',
            options: [
                    @foreach($search_data as $item)
                {title: '{{ $item['title'] }}', id: {{ $item['id'] }}, category: '{{ $item['category'] }}', full_url: '/admin/{{ $item['component'] }}/{{ $item['id'] }}/edit'},
                @endforeach
            ],
            render: {
                item: function(item, escape) {
                    return '<div>' +
                        (item.title ? '<span class="title">' + escape(item.title.replace('&quot;', '').replace('&quot;', '')) + '</span>' : '') +
                        (item.category ? '<span class="category">/' + escape(item.category.replace('&quot;', '').replace('&quot;', '')) + '</span>' : '') +
                        '</div>';
                },
                option: function(item, escape) {
                    return '<div>' +
                        '<span class="uk-label">' + escape(item.title.replace('&quot;', '').replace('&quot;', '')) + '</span>' +
                        (item.category ? '<span class="caption">в разделе: ' + escape(item.category.replace('&quot;', '').replace('&quot;', '')) + '</span>' :'') +
                        '</div>';
                }
            },
            onChange: function (item) {
                window.location = item;
            }
        });
    </script>
@else
    <p class="uk-alert uk-alert-danger">Middleware SiteSearchAdmin not loaded!</p>
@endif