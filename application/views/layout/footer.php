<!-- ========================== Batas Footer ========================== -->
        </div>
			<footer class="footer">
				<div class="container-fluid">
					<div class="copyright ml-auto">
						Copyright © 2023<a href="https://rivvana.id/" target="blank_" class="text-purple"><b> rivvana.id</b></a>
					</div>				
				</div>
			</footer>
		</div>
    </div>
</div>

<div class="mask"></div>
<input type="hidden" name="id_posisi" value="<?= $this->session->userdata('id_posisi') ?>">
<input type="hidden" name="base_url" value="<?= base_url() ?>">
<?php require_once('corejs.php'); ?>

</body>
</html>