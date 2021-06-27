#!/bin/bash
 
mysqldump --opt projekt2016__dv2020diagdiffonline | gzip -c | cat > /srv/home/projekt2016/public/subdomain/dv2020.diagdiff.online/dvdump/dv2020_$(date +%Y%m%d%H%M%S).sql.gz