{{ content() }}

<div id="top-tags">

	<div id="tags-links">
		{# {% cache tags %} #}
		<ul id="tags-header-navigation" class="tags">
			<li class="tags-item">
				Related Tags:
			</li>
			{% for tagItem in tags %}
			<li class="tags-item">
				{{ link_to("tag/" ~ tagItem.name, tagItem.name) }}
			</li>
			{% endfor %}
		</ul>
		{# {% endcache %} #}
	</div>

</div>

<table width="800" align="center" class="artist-showcast" cellspacing="0">
	<tr>
		<td valign="top" class="content" align="left">

			<h2>Popular Albums</h2>

			<table class="albums-index" align="center">
				<tr>
				{% for n, album in albums %}
					<td valign="top" align="left">
						<div class="album-name">
							{{ link_to('album/' ~ album.id ~ '/' ~ album.uri, '<img src="' ~ album.url ~ '" />') }}
						</div>
						<div class="album-name">
							{{ link_to('album/' ~ album.id ~ '/' ~ album.uri, album.name) }}
						</div>
					</td>
					{% if ((n+1) % 3) == 0 %}
						</tr><tr>
					{% endif %}
				{% endfor %}
			</table>

			{% if similars|length %}

				<h2>Similar Artists</h2>

				<table class="albums-index" align="center">
					<tr>
					{% for n, similar in similars %}
						<td valign="top">
							<div class="album-name">
								{{ link_to('artist/' ~ similar.id ~ '/' ~ similar.uri, '<img src="' ~ similar.url ~ '" />') }}
							</div>
							<div class="artist-name">
								{{ link_to('artist/' ~ similar.id ~ '/' ~ similar.uri, similar.name) }}
							</div>
						</td>
						{% if ((n+1) % 3) == 0 %}
							</tr><tr>
						{% endif %}
					{% endfor %}
				</table>

			{% endif %}

		</td>

		<td class="image" valign="top" align="left">

			<img src="{{ photo }}"/>

			<h1>{{ artist.name }}</h1>
			<div class="bio">{{ artist.biography }}</div>

		</td>

	</tr>
</table>

