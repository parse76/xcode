<p>XLaws</p>
<span>z</span>
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	var x;
	$(document).ready(function() {
		$('p').click(function() {
			x = $(this).text();
		});

		$('span').click(function() {
			alert(x);
		});
	});
</script>

{blog_entries}
{title}
{body}
{/blog_entries}