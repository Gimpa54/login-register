<?php 
use App\Utils\Helper;
use App\Utils\Csrf;
use App\Utils\Lang;
?>
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-lg-7">
			<div class="card p-4 shadow-sm">
  				<h2 class="mb-4 text-center"><?= Lang::t('edit_profile')?></h2>

  				<?php include __DIR__ . '/../partials/flash.php'; ?>
  				
  				<form action="/account/edit/<?=$user->id?>" method="POST" enctype="multipart/form-data">
  					<input type="hidden" name="csrf_token" value="<?= Csrf::getToken() ?>">
  					
  					<div class="row">
      					<div class="col-md-6 mb-3">
      						<label for="firstname" class="form-label"><?= Lang::t('name')?></label>
      						<input type="text" class="form-control" id="firstname" name="firstname" value="<?= Helper::old('firstname', $user->firstname ?? '') ?>">
      					</div>
      					
      					<div class="col-md-6 mb-3">
      						<label for="lastname" class="form-label"><?= Lang::t('surname')?></label>
      						<input type="text" class="form-control" id="lastname" name="lastname" value="<?= Helper::old('lastname', $user->lastname ?? '') ?>">
      					</div>
      				</div>
      				
      				<div class="mt-3">
      					<label for="username" class="form-label"><?= Lang::t('username')?></label>
      					<input type="text" class="form-control" id="username" name="username" value="<?= Helper::old('username', $user->username ?? '') ?>">
    				</div>

    				<div class="mt-3">
      					<label for="email" class="form-label"><?= Lang::t('email')?></label>
      					<input type="email" class="form-control" id="email" name="email" value="<?= Helper::old('email', $user->email ?? '') ?>">
    				</div>

    				<div class="mt-3">
      					<label for="avatar" class="form-label"><?= Lang::t('change_avatar')?></label>
      					<img src="/storage/avatars/<?= htmlspecialchars($user->avatar ?? 'default.png') ?>" width="80" height="80" class="rounded-circle mb-2">
      					<input class="form-control" type="file" name="avatar" id="avatar">
      				</div>
      				
      				<div class="row mt-3">
      					<div class="col-md-12">
        					<label for="bio" class="form-label"><?= Lang::t('biography')?></label>
        					<textarea class="form-control" name="bio" id="bio" rows="3"><?= Helper::old('bio', $user->bio ?? '') ?></textarea>
      					</div>
    				</div>
    				
    				<div class="row mt-3">
    					<div class="col-md-3">
        					<label for="phone" class="form-label"><?= Lang::t('telephone')?></label>
        					<input type="text" class="form-control" name="phone" id="phone" value="<?= Helper::old('phone', $user->phone ?? '') ?>">
      					</div>
      					<div class="col-md-3">
        					<label for="city" class="form-label"><?= Lang::t('city')?></label>
        					<input type="text" class="form-control" name="city" id="city" value="<?= Helper::old('city', $user->city ?? '') ?>">
      					</div>
      					<div class="col-md-6">
        					<label for="address" class="form-label"><?= Lang::t('address')?></label>
        					<input type="text" class="form-control" name="address" id="address" value="<?= Helper::old('address', $user->address ?? '') ?>">
      					</div>
      					<div class="col-md-4">
        					<label for="postal_code" class="form-label"><?= Lang::t('postcode')?></label>
        					<input type="text" class="form-control" name="postal_code" id="postal_code" value="<?= Helper::old('postal_code', $user->postal_code ?? '') ?>">
      					</div>
      					<div class="col-md-4">
        					<label for="province" class="form-label"><?= Lang::t('province')?></label>
        					<input type="text" class="form-control" name="province" id="province" value="<?= Helper::old('province', $user->province ?? '') ?>">
      					</div>
      					<div class="col-md-4">
      						<label for="country" class="form-label"><?= Lang::t('country')?></label>
      						<input type="text" class="form-control" name="country" id="country" value="<?= Helper::old('country', $user->country ?? '') ?>">
    					</div>
    				</div>
    				<div class="mt-4">
      					<button type="submit" class="btn btn-success"><?= Lang::t('save_changes')?></button>
    				</div>
  				</form>
  			</div>
  		</div>
  	</div>
</div>