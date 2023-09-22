Styles are applied following these rules. In quotes, there's respective OPC module configuration switch.

1/ 'use custom styling' = OFF
   
   base.css - always included
   + single/two/three-column.css - one of them included, based on 'three column layout' or 'two column layout'
   + themes/THEME_NAME/base.css - if exists
   + themes/THEME_NAME/single/two/three-column.css - if exists

2/ 'use custom styling' = ON

   base-custom.css - always included
   + single/two/three-column-custom.css - one of them included, based on 'three column layout' or 'two column layout'
   + themes/THEME_NAME/base-custom.css - if exists, if not: themes/THEME_NAME/base.css - if exists
   + themes/THEME_NAME/single/two/three-column-custom.css - if exists, if not: themes/THEME_NAME/single/two/three-column.css - if exists  
