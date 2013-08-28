{{ content() }}

{{ stylesheet_link('css/albums/' ~ album.id ~ '.css') }}

<div id="top-tags">

	<div id="tags-links">
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
	</div>

</div>

<div id="breadcrumbs">
	{{ link_to("", "Home") }} &gt; {{ link_to("artist/" ~ artist.id ~ '/' ~ artist.uri , artist.name) }}
</div>

<table width="800" align="center" class="album-showcast">
	<tr>
		<td class="image" valign="top">

			<img src="{{ photo }}"/>

		</td>
		<td valign="top" align="left">

			<h1>{{ album.name }} / {{ artist.name }}</h1>
			<span class="release-date">{{ album.release_date }}</span>
			<div class="summary">{{ album.summary|nl2br }}</div>

			{% if tracks|length %}
			<table class="tracks" cellspacing="0">
				{% for track in tracks %}
					<tr>
						<td class="track-number">{{ track.rank }}</td>
						<td>{{ track.name }}</td>
						<td class="track-duration">{{ track.duration }}</td>
						{% if track.href %}
							<td class="track-play"><a href="{{ track.href }}">Play</a></td>
						{% endif %}
					</tr>
				{% endfor %}
			</table>
			{% else %}
			<p>Track info is not available</p>
			{% endif %}

		</td>
	</tr>
</table>
