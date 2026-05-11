# Project Description

## Database Schema

### Entities

- `users`
  - `id`, `name`, `email`, `password`, `role`, timestamps
- `categories`
  - `id`, `name`, `slug`, timestamps
- `listings`
  - `id`, `user_id`, `category_id`, `title`, `description`, `price`, `condition`, `size`, `status`, timestamps
- `listing_images`
  - `id`, `listing_id`, `path`, `is_primary`, timestamps

### Relationships

- One `User` has many `Listing`
- One `Category` has many `Listing`
- One `Listing` belongs to one `User`
- One `Listing` belongs to one `Category`
- One `Listing` has many `ListingImage`

## Laravel Structure

- Models:
  - `User`
  - `Category`
  - `Listing`
  - `ListingImage`
- Controllers:
  - `ListingController`
  - `DashboardController`
  - `Admin\AdminDashboardController`
  - `Admin\AdminCategoryController`
  - `Admin\AdminListingController`
  - `Admin\AdminUserController`
- Validation:
  - `StoreListingRequest`
  - `UpdateListingRequest`
  - `ListingFilterRequest`
  - `StoreCategoryRequest`
  - `UpdateCategoryRequest`
- Security:
  - `ListingPolicy`
  - `EnsureUserIsAdmin` middleware

## Key Design Decisions

- Breeze is used for authentication so the project stays inside the Laravel ecosystem.
- Bootstrap is loaded from CDN to keep the frontend simple and avoid a Node build requirement.
- Listing authorization uses a policy instead of manual controller checks.
- Filtering logic is kept in Eloquent query scopes for cleaner controllers.
- Images are stored on Laravel's public disk and deleted together with the listing.

## Filtering and Sorting

- Search in title and description
- Filter by category
- Filter by price range
- Filter by size
- Filter by condition
- Sort by newest, oldest, price ascending, or price descending
