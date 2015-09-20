<div align="center">

	<div id="top-menu">

		<div id="logo">
			{{ link_to("index", "<h1>Album O´Rama</h1>", "alt": "Go Home") }}
		</div>

		<div id="menu-divider"></div>
		<div style="height: 60px; float: left;">
			<div id="menu-links">
				<ul id="menu-header-navigation" class="menu">
					<li class="menu-item">
						{{ link_to("index", "Home") }}
					</li>
					<li class="menu-item">
						{{ link_to("popular", "Popular") }}
					</li>
					<li class="menu-item">
						{{ link_to("charts", "Charts") }}
					</li>
					<li class="menu-item">
						{{ link_to("about", "About") }}
					</li>
				</ul>
			</div>

			<div id="header-search">
				{{ form("search") }}
				<div>
					<input id="s" type="text" name="s" value="">
					<input id="searchsubmit" type="submit" value="Search">
				</div>
				</form>
			</div>
		</div>
	</div>

	{{ content() }}

	<div id="footer">
		Powered by {{ link_to("about", "Phalcon PHP Framework") }}
	</div>

</div>
