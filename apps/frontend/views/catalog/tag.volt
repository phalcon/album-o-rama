
{{ content() }}

<div class="section-header">
	<h2>Tagged {{ tag.name }}</h2>
</div>

{% include "partials/album-list.volt" %}

<div id="paginator">

	{% if prev %}
	<div class="prev">
		{{ link_to('tag/' ~ tag.name ~ '/' ~ prev, 'Previous Page') }}
	</div>
	{% endif %}

	{% if next %}
	<div class="next">
		{{ link_to('tag/' ~ tag.name ~ '/' ~ next, 'Next Page') }}
	</div>
	{% endif %}

</div>