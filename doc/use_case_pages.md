# Pages

Pages represent a customizable web page, you can adjust them to your needs in the admin panel.

With the BitBag SyliusCmsPlugin, administrators can associate related products with CMS pages, displaying them in the designated section.

This feature allows for targeted product recommendations and cross-selling opportunities within the content.

Additionally, administrators can incorporate media elements, such as images and videos, into the pages,
enriching the visual presentation and engaging users.

The flexibility of the plugin empowers administrators to create compelling CMS pages that seamlessly integrate product
information and multimedia content, enhancing the overall user experience.

**Note.** If you haven't implemented the Pages properly in your code yet, please visit [Pages](pages.md) tech doc.

## The process of creating a Page

By following the steps below, administrators can add pages and associate them with products, allowing the pages to display relevant product information. This integration enhances the browsing experience by providing seamless access to product details directly from the associated pages.

1. Please access the administrator panel of the Sylius e-commerce system.
2. Navigate to the CMS section or the designated area for managing pages.
3. Select the option to create a new page.
4. Fill in the required fields in the page creation form, such as the name, content, and slug.
5. Save the page after filling in the necessary details and selecting any desired associations.
6. Repeat the process to add additional pages, as needed.
7. After refreshing the store page, the newly implemented changes should now be visible.

### Optional configuration

In the form, you will find fields,  which will help you with your e-commerce related content:

- Products - You can associate specific products with the page. This means that the page will display and provide information related to the selected products.
- Sections - You can choose the sections where the page should be placed, ensuring proper organization and positioning of the page within the website's structure.

The mentioned form:

![Screenshot showing content management config in admin](pages_create_cms.png)

## Result possible to achieve on the front of the store:

The image below displays a [Section](sections.md), to which we have attached two pages:

![Screenshot showing content management config in admin](pages_cms_result_1.png)

Additionally, every page has its own slug, so you can access its all contents by visiting it by a full URL:

![Screenshot showing content management config in admin](pages_cms_result_2.png)

