<!-- {base_url}
{elapsed_time}
{blog_entries}
<h5>{title}</h5>
<p>{body}</p>
{/blog_entries} -->

<?php

// preprint($_SESSION);
// print_r($_SESSION);

// preprint($_COOKIE['ci_session']);
print_r($_COOKIE['ci_session']);

echo anchor('account/logout', 'Logout');

?>