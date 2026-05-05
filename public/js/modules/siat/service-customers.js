(function(ns)
{
	class ServiceCustomers extends SBFramework.Classes.Api
	{
		constructor()
		{
			super();
		}
		getHeaders()
		{
			const headers = {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content};
			
			return headers;
		}
		async create(customer)
		{
			const headers = this.getHeaders();
			const res = await this.Post(`/invoices/siat/v2/customers`, customer, headers);
			
			return res;
		}
		async update(customer)
		{
			const headers = this.getHeaders();
			const res = await this.Put(`/invoices/siat/v2/customers`, customer, headers);
			
			return res;
		}
		async read(id)
		{
			const res = await this.Get(`/invoices/siat/v2/customers/${id}`);
			
			return res;
		}
		async readAll(page)
		{
			const res = await this.Get(`/invoices/siat/v2/customers?page=`+page);
			
			return res;
		}
		async cargarClientes()
		{
			const res = await this.Get(`/invoices/siat/v2/get_customers`);
			
			return res;
		}
		async remove(id)
		{
			const headers = this.getHeaders();
			const res = await this.Delete(`/invoices/siat/v2/customers/${id}`, headers);
			
			return res;
		}
		async search(keyword, page)
		{
			const headers = this.getHeaders();
			const res = await this.Get(`/invoices/siat/v2/customers?q=${keyword}&page=`+page, headers);
			
			return res;
		}
	}
	ns.ServiceCustomers = ServiceCustomers;
})(SBFramework.Services);
