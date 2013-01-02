
{{ content() }}

<div class="section-header">
	<h2>Searching Artists</h2>
</div>

<table class="albums-index">
	<tr>
	{% for n, artist in artists %}
		<td valign="top">
			<div class="album-name">
				{{ link_to('artist/' ~ artist.id ~ '/' ~ artist.uri, '<img src="' ~ artist.url ~ '" />') }}
			</div>
			<div class="artist-name">
				{{ link_to('artist/' ~ artist.id ~ '/' ~ artist.uri, artist.name) }}
			</div>
		</td>
		{% if ((n+1) % 6) == 0 %}
			</tr><tr>
		{% endif %}
	{% endfor %}
</table>

{# <table class="albums-index">
	{% set n = 1 %}
	<tr>
	{% for album in albums %}
		<td valign="top">
			<div class="album-name">
				<img src="{{ album.url }}" />
			</div>
			<div class="album-name">
				{{ link_to('album/' ~ album.id ~ '/' ~ album.uri, album.name) }}
			</div>
			<div class="artist-name">
				{{ link_to('artist/' ~ album.artist_id ~ '/' ~ album.uri, album.artist) }}
			</div>
		</td>
		{% if (n % 6) == 0 %}
			</tr><tr>
		{% endif %}
		{% set n = n + 1 %}
	{% endfor %}
</table> #}