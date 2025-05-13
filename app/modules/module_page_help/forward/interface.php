<div class="row">
	<div class="col-md-3">
		<div class="rules_sticky">
			<div class="rules_card">
				<div class="rules_margin">
					<div class="rules_chapter">
						<svg viewBox="0 0 576 512">
							<path d="M63.1 336c0 8.836 7.164 16 15.1 16h31.1c8.836 0 16-7.164 16-16L127.1 288h47.1c8.836 0 16-7.165 16-16v-32c0-8.836-7.165-15.1-16-15.1H127.1l.0006-47.1c0-8.836-7.165-15.1-16-15.1H79.1c-8.836 0-15.1 7.163-15.1 15.1L63.1 224H16c-8.836 0-16 7.163-16 15.1v32c0 8.836 7.164 16 16 16h47.1L63.1 336zM574.4 435.4l-107.7-399.9C460.9 14.07 441.5 0 420.4 0c-4.111 0-8.296 .5313-11.46 1.641l-61.82 16.48c-1.281 .3438-1.375 .9922-3.592 1.445C333.7 7.758 319.8 0 304 0h-64c-11.35 0-23.49 4.797-32 11.46C199.5 4.797 188.3 0 176 0h-64C85.49 0 64 21.49 64 48v64C64 120.8 71.16 128 80 128h112L192 176C192 184.8 199.2 192 208 192S224 184.8 224 176L224 128H320v256H224L224 336C224 327.2 216.8 320 208 320S192 327.2 192 336L192 384H80C71.16 384 64 391.2 64 400v64C64 490.5 85.49 512 112 512h64c11.35 0 23.49-4.797 32-11.46C216.5 507.2 227.7 512 240 512h64c26.51 0 48-21.49 48-48V224.7l67.8 251.9C425.6 497.9 444.9 512 466.1 512c4.111 0 8.293-.5313 11.46-1.641l61.91-16.51C566.1 487 581.2 460.8 574.4 435.4zM192 96H96V48C96 39.18 103.2 32 112 32h64C184.8 32 192 39.18 192 48L192 96zM192 464C192 471.8 184.8 480 176 480h-64C103.2 480 96 471.8 96 464V416h96L192 464zM320 464c0 8.824-7.178 16-16 16h-64C231.2 480 224 471.8 224 464L224 416H320V464zM320 96H224L224 48C224 39.18 231.2 32 240 32h64C311.8 32 320 39.18 320 48V96zM352 101.6V50.29c.834-.3906 1.322-.9727 1.322-1.242l61.82-16.48C417.5 31.19 418.1 32 420.4 32c7.225 0 13.57 4.828 15.43 11.74l11.4 46.07l-91.71 24.73L352 101.6zM430 391.4l-66.26-246.1l91.71-24.73l66.26 246.1L430 391.4zM541.9 455.5c-1.23 1.133-4.133 5.934-9.729 7.43l-61.82 16.48C468.1 479.8 467.5 480 466.1 480c-7.227 0-13.57-4.828-15.43-11.74l-11.4-46.07l91.71-24.73l11.44 46.22C544.9 449.1 543.1 453.4 541.9 455.5z" />
						</svg>
						<?=$Translate->get_translate_module_phrase('module_page_help', '_Knowledge_base')?>
					</div>
					<div class="rules_card_block">
						<div class="rules_card_left" id="help_buttons"></div>
						<?php if ($help->access()) : ?>
							<div class="rules_menu add_category" onclick="Ajax('add_category_btn')">
							<?=$Translate->get_translate_module_phrase('module_page_help', '_Add_category')?>
							</div>
							<div class="rules_menu add_category" onclick="Ajax('add_content_btn')">
								<?=$Translate->get_translate_module_phrase('module_page_help', '_Add_item')?>
							</div>
						<?php endif; ?>
						<?php if (isset($_SESSION['user_admin'])) : ?>
							<div class="rules_menu add_category" data-openmodal="modal_access">
								Управление доступом
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="rules_card">
			<div id="help_block" class="rules_block" content_id="0">
				<?php if ($help->access()) : ?>
					<div class="help_buttons">
						<div class="edit_content" onclick="Ajax('edit_content_btn')">
							<svg viewBox="0 0 512 512">
								<path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"></path>
							</svg>
						</div>
						<div class="delete_content" onclick="Ajax('del_content')">
							<svg viewBox="0 0 320 512">
								<path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
							</svg>
						</div>
					</div>
				<?php endif; ?>
				<div id="help_content">
					<div class="toastui-editor-contents" style="overflow-wrap: break-word;">
						<div id="content"></div>
					</div>
				</div>
				<div class="time_short_text">
					<svg viewBox="0 0 512 512">
						<path d="M240 112C240 103.2 247.2 96 256 96C264.8 96 272 103.2 272 112V247.4L360.9 306.7C368.2 311.6 370.2 321.5 365.3 328.9C360.4 336.2 350.5 338.2 343.1 333.3L247.1 269.3C241.7 266.3 239.1 261.3 239.1 256L240 112zM256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM32 256C32 379.7 131.3 480 256 480C379.7 480 480 379.7 480 256C480 131.3 379.7 32 256 32C131.3 32 32 131.3 32 256z" />
					</svg>
					<div id="content_date"></div>
				</div>
			</div>
		</div>
	</div>
	<?php if ($help->access()) : ?>
		<?php require MODULES . 'module_page_help/includes/editor.php'; ?>
		<?php require MODULES . 'module_page_help/includes/category.php'; ?>
	<?php endif; ?>
	<?php if (isset($_SESSION['user_admin'])) : ?>
		<?php require MODULES . 'module_page_help/includes/access.php'; ?>
	<?php endif; ?>
</div>
<?php if ($help->access()) : ?>
	<script src="https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.min.js"></script>
	<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
	<script src="https://uicdn.toast.com/editor-plugin-color-syntax/latest/toastui-editor-plugin-color-syntax.min.js"></script>
	<script>
		const Editor = toastui.Editor;
		const editor = new Editor({
			el: document.querySelector("#editor"),
			height: "500px",
			initialEditType: "wysiwyg",
			hideModeSwitch: true,
			theme: "dark",
			plugins: [toastui.Editor.plugin.colorSyntax],
			hooks: {
				addImageBlobHook: function(blob, callback) {
					const formData = new FormData();
					formData.append("action", "upload_image");
					formData.append("content_id", $("#help_block").attr("content_id"));
					formData.append("image", blob);
					$.ajax({
						url: location.href,
						type: "POST",
						data: formData,
						processData: false,
						contentType: false,
						dataType: "json",
						success: function(response) {
							if (response && response.status == "success") {
								callback(response.url, "alt text");
							} else {
								noty(response.text, "error");
							}
						},
					});
				},
			},
		});
		editor.removeToolbarItem('codeblock');
	</script>
<?php endif; ?>