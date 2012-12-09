
<div id="top-tags">

	<div id="tags-links">
		<ul id="tags-header-navigation" class="tags">
			<li class="tags-item">
				Random Tags:
			</li>
			{% for tag in tags %}
			<li class="tags-item">
				{{ link_to("tag/" ~ tag.name, tag.name) }}
			</li>
			{% endfor %}
		</ul>
	</div>

</div>

<div class="section-header">
	<h2>Random Albums</h2>
</div>

{{ partial('partials/album-list') }}