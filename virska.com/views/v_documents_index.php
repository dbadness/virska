<div id="docUpload">
	<form id="docUploadForm" action="/documents/p_upload_doc" method="post" enctype="multipart/form-data">
			<input id="docUploadName" size="40" name="doc_name" placeholder="Document Name">
			<input id="file" type="file" name="doc">
			<select id="docType" name="doc_type">
				<option value="pdf">PDF</option>
				<option value="doc">Word</option>
				<option value="xsl">Excel</option>
				<option value="ppt">Powerpoint</option>
			</select>
			<input id="uploadButton" type="submit" value="Upload Document">
		<div style="clear:both;"></div>
	</form>
</div>
<div class="spacer"></div>
<div id="docsList">
	<?foreach($docs as $doc):?>
		<div id="doc" class="listItem">
			<div id="docName">
				<?=$doc['doc_name']?>
			</div>
			<div id="docDelete">
				<a class="delete" href="/documents/p_delete_doc/<?=$doc['doc_id']?>">Delete</a>
			</div>
			<div id="docDownload">
				<a href="/docs/<?=$doc['doc']?>.<?=$doc['doc_type']?>">Download</a>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?endforeach;?>
</div>
<div class="spacer"></div>