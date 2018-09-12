<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="ru-RU">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo __( 'New message from site ', 'zhivo' ) . get_bloginfo( 'name' ); ?></title>
</head>
<body style="margin: 0; padding: 0; font: 16px Arial, sans-serif; color: #333333; background-color: #ffffff;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" bgcolor="#ffffff" style="margin: 0 auto; padding: 10px;">
		<tr>
			<td valign="top">
				<table border="0" cellpadding="0" cellspacing="0" width="600px" style="margin: 0 auto 20px auto; padding: 10px;">
					<tr>
						<td style="padding: 0 11px;">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="font-size: 24px; font-weight: 700; text-decoration: none; line-height: 30px; -webkit-text-size-adjust: none; color: #337ab7;" target="_blank"><?php bloginfo( 'name' ); ?></a>
						</td>
					</tr>
					<tr>
						<td style="padding: 11px;">
							<?php
							printf(
								// translators: Link to site
								__( 'New message from site %s:', 'zhivo' ),
								'<a href="'. esc_url( home_url( '/' ) ) . '" style="font-weight: 700; text-decoration: none; color: #337ab7;" target="_blank">' . esc_url( home_url() ) . '</a>'
							);
							?>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<table border="0" cellpadding="0" cellspacing="2px" width="100%" height="100%" style="color: #555555;">
							<?php
							$c = true;
							foreach ( $mail_data as $data ) {
							echo ($c = !$c) ? '<tr>' : '<tr style="background-color: #f8f8f8;">'; ?>
									
									<td style="padding: 10px; border: #e9e9e9 1px solid;"><b><?php echo $data['label']; ?></b></td>
									<td style="padding: 10px; border: #e9e9e9 1px solid;"><?php echo $data['data']; ?></td>
								</tr>
							<?php } ?>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<span style="padding: 11px; color: #333333; font: 11px Arial, sans-serif; font-style: italic; -webkit-text-size-adjust:none; display: block;">
							<?php
							printf(
								// translators: Formatted date, see http://php.net/date
								__( 'This mail was generated at %s (server time).', 'zhivo' ),
								'<b>' . date_i18n( __( 'M j, Y @ H:i', 'zhivo' ) ) . '</b>'
							);
							?>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
