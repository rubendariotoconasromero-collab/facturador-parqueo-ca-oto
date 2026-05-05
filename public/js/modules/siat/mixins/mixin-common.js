(function(ns)
{
	ns.Common = 
	{
		methods: 
		{
			openModal($modal)
			{
				/*if( $modal.show )
				{
					$modal.show();
					
					return true;
				}
				jQuery($modal).modal('show');*/
				if( $modal.modal )
				{
					jQuery($modal).modal('show');
					return true;
				}
				$modal.show();
			},
			closeModal($modal)
			{
				/*if( $modal.modal )
				{
					jQuery($modal).modal('hide');
					return true;
				}
				$modal.hide();*/
				if( $modal.modal )
				{
					jQuery($modal).modal('hide');
					return true;
				}
				$modal.hide();
			}
		}
	};
})(SBFramework.Mixins);