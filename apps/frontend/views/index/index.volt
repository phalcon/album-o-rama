
<div id="top-tags">

	<div id="tags-links">
		<ul id="tags-header-navigation" class="tags">
			<li class="tags-item">
				Random Tags:
			</li>
			{% for tagItem in tags %}
			<li class="tags-item">
				{{ link_to("tag/" ~ tagItem.name, tagItem.name) }}
			</li>
			{% endfor %}
		</ul>
	</div>

</div>

<div class="section-header">
	<h2>Random Albums</h2>
</div>

{{ partial('partials/album-list') }}
