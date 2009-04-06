The taxonomy_fields module brings two important modules together: CCK and taxonomy. As CCK can assign fields to content types, taxonomy_fields can assign CCK fields to categories. By doing this, content types are not limited to the same range of fields anymore.
Nodes of the same content type can now contain absolutely different fields. Simply assign a field to a term and every node in this category will now contain this field. When choosing a new term for a node, the field-form will appear next time on the edit-page.

Further more taxonomy_fields gives you two extra options:

Universal values for fields. 
When activated, this field will always carry the same value for this term, users can not edit the value. This option can be used for standard disclaimers for example. Does not work with image-fields and file-fields.

Ancestor fields. 
When activated, all nodes will show the fields of all ancestors of this term. Can be used with single and multiple hierarchies, so you don't have to assign the same field to all of your sub-categories.