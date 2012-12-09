{{ content() }}

<div id="top-tags">

	<div id="tags-links">
		<ul id="tags-header-navigation" class="tags">
			<li class="tags-item">
				Related Tags:
			</li>
			{% for tag in tags %}
			<li class="tags-item">
				{{ link_to("tag/" ~ tag.name, tag.name) }}
			</li>
			{% endfor %}
		</ul>
	</div>

</div>

<table width="800" align="center" class="artist-showcast" cellspacing="0">
	<tr>
		<td valign="top" class="content">

			<h2>Popular Albums</h2>

			<table class="albums-index" align="center">
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
					</td>
					{% if (n % 3) == 0 %}
						</tr><tr>
					{% endif %}
					{% set n = n + 1 %}
				{% endfor %}
			</table>

			{% if similars|length %}

				<h2>Similar Artists</h2>

				<table class="albums-index" align="center">
					{% set n = 1 %}
					<tr>
					{% for similar in similars %}
						<td valign="top">
							<div class="album-name">
								<img src="{{ similar.url }}" />
							</div>
							<div class="artist-name">
								{{ link_to('artist/' ~ similar.id ~ '/' ~ similar.uri, similar.name) }}
							</div>
						</td>
						{% if (n % 3) == 0 %}
							</tr><tr>
						{% endif %}
						{% set n = n + 1 %}
					{% endfor %}
				</table>

			{% endif %}

		</td>

		<td class="image" valign="top">

			<img src="{{ photo }}"/>

			<h1>{{ artist.name }}</h1>
			<div class="bio">{{ artist.biography }}</div>

		</td>

	</tr>
</table>

