<?php
$this->title = 'Dashboard';
?>

<div class="site-index">
	<div class="body-content">
		
		<?php if ($user->isEditor()): ?>
			<h1><?= $user->heritage->short_name ?></h1>
			
			<div class="row">
				<div class="col-md-4 margin-bottom">
					<?php
					/*
					<div class="col-md-4 margin-bottom">
						<div class="h1">Heritage</div>
						<p class="lead">
							<a href="/heritage/update/<?= $user->heritage_id ?>">
								Heritage Page
							</a>
						</p>
					</div>
					*/
					?>
					<p class="lead">
						<a href="/poi">
							Points of Interest
						</a>
					</p>
					<p class="lead">
						<a href="/route">
							Routes
						</a>
					</p>
					<p class="lead">
						<a href="/article">
							Articles
						</a>
					</p>
					<p class="lead">
						<a href="/event">
							Events
						</a>
					</p>
					<p class="lead">
						<a  href="/code/list">
							NFC Codes
						</a>
					</p>
				</div>
			</div>
		<?php endif; ?>
		
		<?php if ($user->isAdmin()): ?>
	
			<div class="row">
				<div class="col-md-4 margin-bottom">
					<div class="h1">Pages</div>
					<p class="lead">
						<a  href="/page/update/1">
							Homepage
						</a>
					</p>
					<p class="lead">
						<a  href="/page/update/2">
							About
						</a>
					</p>
					<p class="lead">
						<a  href="/page/update/3">
							Privacy Policy
						</a>
					</p>
					<p class="lead">
						<a  href="/page/update/4">
							Contact
						</a>
					</p>
				</div>
			
				<div class="col-md-4 margin-bottom">
					<?php if ($user->isSuperAdmin()): ?>
						<div class="h1">Tags & Filters</div>
						<p class="lead">
							<a  href="/tag">
								Tags
							</a>
						</p>
						<p class="lead">
							<a  href="/flag-group">
								Filters
							</a>
						</p>
					<?php else: ?>
						<div class="h1">Tags</div>
						<p class="lead">
							<a  href="/tag">
								Tags
							</a>
						</p>
					<?php endif; ?>
				</div>
			
				<div class="col-md-4 margin-bottom">
					<div class="h1">Users</div>
					<p class="lead">
						<a  href="/admin">
							Admin Users
						</a>
					</p>
				</div>
				
			</div>
			
			<div class="row">
				<div class="col-md-4 margin-bottom">
					<div class="h1">Heritages</div>
					<p class="lead">
						<a href="/heritage">
							Heritages
						</a>
					</p>
				</div>
				
				<div class="col-md-4 margin-bottom">
					<div class="h1">Content</div>
					<p class="lead">
						<a href="/poi">
							Points of Interest
						</a>
					</p>
					<p class="lead">
						<a href="/route">
							Routes
						</a>
					</p>
					<p class="lead">
						<a href="/article">
							Articles
						</a>
					</p>
					<p class="lead">
						<a href="/event?EventSearch[archive]=0">
							Events
						</a>
					</p>
					<p class="lead">
						<a href="/supplier">
							Suppliers
						</a>
					</p>
				</div>
				
				<div class="col-md-4 margin-bottom">
					<div class="h1">Quality Control</div>
					<p class="lead">
						<a href="/quality-control/approve">
							To approve 
							<?php if ($approveCount > 0): ?>
								<span class="badge"><?= $approveCount ?></span>
							<?php endif; ?>
						</a>
					</p>
					<p class="lead">
						<a href="/quality-control/edited">
							Edited 
							<?php if ($editedCount > 0): ?>
								<span class="badge"><?= $editedCount ?></span>
							<?php endif; ?>
						</a>
					</p>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-4 margin-bottom">
					<div class="h1">NFC</div>
					<p class="lead">
						<a  href="/code-series">
							Code Series
						</a>
					</p>
				</div>
			</div>
		<?php endif; ?>
        
    </div>
</div>
