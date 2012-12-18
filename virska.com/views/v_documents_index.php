<?if($doc_size < 2 * 1073741824):?>
<div id="docUpload">
	<form id="docUploadForm" action="/documents/p_upload_doc" method="post" enctype="multipart/form-data">
			<input id="file" type="file" name="doc">
			<input id="uploadButton" type="submit" value="Upload Document">
		<div style="clear:both;"></div>
	</form>
</div>
<?else:?>
<div id="docUpload">
	You're over your 2GB limit. Please delete documents to add more.
</div>
<?endif;?>	
<div id="docLimitBox">
	<?=round(($doc_size / 1073741824), 2)?> GB used, <?=2 - (round(($doc_size / 1073741824), 2))?> GB remaining
</div>
<div style="clear:both;"></div>
<div class="spacer"></div>
	<?if($docs):?>
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
						<a href="/docs/<?=$doc['doc_code']?>">Download</a>
					</div>
					<div style="clear:both;"></div>
				</div>
			<?endforeach;?>
		</div>
	<?else:?>
		<div id="docList" style="text-align:center;">
			<i>No documents uploaded to the cloud.... yet.</i>
		</div>
	<?endif;?>