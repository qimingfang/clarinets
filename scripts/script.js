var editor = undefined;

$(document).ready(function() {
	
	$("#blog_entry").markItUp(mySettings, {
		previewInWindow : 'width=800, height=600, resizable=yes, scrollbars=yes'
	});

	$("#about_us").markItUp(mySettings, {
		previewInWindow : 'width=800, height=600, resizable=yes, scrollbars=yes'
	});
	
	$(".photo_container").mouseover(function(){
		$(this).children(".shading").css({
			display : "block"
		});
	});
	
	$(".photo_container").mouseout(function(){
		$(this).children(".shading").css({
			display : "none"
		});
	});
	
	$(".photo_delete").click(function(){
		return confirm("Are You Sure?");
	})

	$('#file_tree').fileTree({
		root : './',
		script : 'jqueryFileTree.php',
		expandSpeed : -1,
		collapseSpeed : -1,
		multiFolder : true
	}, function(file) {
		if (editor == undefined ||
			(editor != undefined && confirm("Change Files? (unsaved changes will be lost)"))){
			
			$("#file_editor_form").css({
				display:"block"
			});
			
			if (editor != undefined) editor.toTextArea();
			
			$("#file_editor").val($.ajax({
				url : 'ajax.php?file=' + file,
				async : false
			}).responseText);
	
			var extension = file.split('.').pop();
			if (extension == "js") extension = "javascript"
	
			editor = CodeMirror.fromTextArea(document.getElementById("file_editor"), {
				lineNumbers : true,
				matchBrackets : true,
				lineWrapping : true,
				mode : extension,
				//mode : "application/x-httpd-php",
				indentUnit : 4,
				indentWithTabs : true,
				enterMode : "keep",
				tabMode : "shift"
			});
		}
	});
	
	$("#file_editor_save").click(function(){
		editor.save();
		
		$.post("editor.php", { submit : "submit", file_editor : $("#file_editor").val()}, function(data){
			if ((data) == 1){
				$("#status").css({
					display : "inline",
					color : "green"
				});
				$("#status").html("Saved Successfully");
			} else {
				$("#status").css({
					display : "inline",
					color : "red"
				})
				$("#status").html("Save Failed");
			}
			
			$("#status").fadeOut(1500);
		});
		
		return false;
	});
});
