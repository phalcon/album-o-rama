{{ get_doctype() }}
<html lang="en" id="site" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta content="IE=edge" http-equiv="X-UA-Compatible">
		{{ get_title() }}
		{{ stylesheet_link("css/style.css") }}
		<link rel="icon" href="favicon.ico?v=0.1" sizes="16x16 32x32 48x48 64x64" type="image/vnd.microsoft.icon">
	</head>
	<body>
		{{ content() }}
	</body>
</html>
