$(function() {
	// highlight.js
	hljs.configure({
		tabReplace: '    ',
		languages: ["PHP", "CoffeeScript", "CSS", "Diff", "JavaScript", "JSON"]
	});
	hljs.initHighlighting();
	$("pre").each(function(i, block) {
		hljs.highlightBlock(block);
	});

	// Pagination
	var next = $('ul.pagination li.active').nextAll().slice(0,5).last(),
		nextHide = next.nextUntil($('ul.pagination li.last')),
		prev = $('ul.pagination li.active').prevAll().slice(0,5).last(),
		prevHide = prev.prevUntil($('ul.pagination li.first'));

		prevHide.hide();
		nextHide.hide();
});
