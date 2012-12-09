
<table class="albums-index">
	{% set n = 1 %}
	<tr>
	{% for album in albums %}
		<td valign="top">
			<div class="album-name">
				{{ link_to('album/' ~ album.id ~ '/' ~ album.uri, '<img src="' ~ album.url ~ '" alt="' ~ album.name ~ '"/>') }}
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
</table>