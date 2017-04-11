<h3>{% title %}'s user list</h3>
<ul>
{% for users in user %}
	<li><a href="./user/{% user.id %}"><b>{% user.name %}</b></a></li>
{% end %}
</ul>
