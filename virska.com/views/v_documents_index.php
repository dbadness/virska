<?if($doc_size < 104857600):?>
	<div id="docUpload">
		You can upload Word, Excel, PowerPoint, and PDF files to download later from any computer with internet.<br><br>
		<form id="docUploadForm" action="/documents/p_upload_doc" method="post" enctype="multipart/form-data">
				<input id="file" type="file" name="doc">
				<input id="uploadButton" type="submit" value="Upload Document">
			<div style="clear:both;"></div>
		</form>
	</div>
<?else:?>
	<div id="docUpload">
		You're over your 100 MB limit. Please delete documents to add more.
	</div>
<?endif;?>	
<div id="docLimitBox">
	<?=round(($doc_size / 1048576), 2)?> MB used, <?=100 - (round(($doc_size / 1048576), 2))?> MB remaining
</div>					
<div style="clear:both;"></div>
<?if(isset($error)):?>
	<?if($error == 1):?>
		<div class="docError">
			Virska only accepts Word, Excel, Powerpoint, Pages, Numbers, Keynote, PDF, PNG and JPG file formats at this time.
		</div>
	<?elseif($error == 2):?>
		<div class="docError">
			That file already exists in your cloud. Please change the file name or delete the file that already exists.
		</div>
	<?endif;?>
<?endif;?>
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