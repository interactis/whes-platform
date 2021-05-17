<?php
$this->title = 'Dashboard';
?>

<div class="site-index">
	<div class="body-content">
	
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
							Legal Notice
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
		
		<?php endif; ?>
        
        <div class="row">
        	
        	<?php if ($user->isAdmin()): ?>
				<div class="col-md-4 margin-bottom">
					<div class="h1">Heritages</div>
					<p class="lead">
						<a href="/heritage">
							Heritages
						</a>
					</p>
				</div>
        	<?php endif; ?>
        	
        	<?php if ($user->isEditor()): ?>
				<div class="col-md-4 margin-bottom">
					<div class="h1">Heritage</div>
					<p class="lead">
						<a href="/heritage/update/<?= $user->heritage_id ?>">
							Heritage Page
						</a>
					</p>
				</div>
        	<?php endif; ?>
        	
            <div class="col-md-4 margin-bottom">
                <div class="h1">Contents</div>
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
        	</div>
        </div>
        
    </div>
</div>
