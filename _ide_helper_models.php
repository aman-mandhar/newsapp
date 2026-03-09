<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $comment_text
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCommentText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $edition_id
 * @property string $title
 * @property string $body
 * @property string|null $section
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EpaperEdition $edition
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EpaperRegion> $regions
 * @property-read int|null $regions_count
 * @method static \Database\Factories\EpaperArticleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle whereEditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperArticle whereUpdatedAt($value)
 */
	class EpaperArticle extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $edition_name
 * @property \Illuminate\Support\Carbon $issue_date
 * @property string $status
 * @property string $pdf_path
 * @property int $total_pages
 * @property \Illuminate\Support\Carbon|null $generated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EpaperArticle> $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EpaperPage> $pages
 * @property-read int|null $pages_count
 * @method static \Database\Factories\EpaperEditionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition whereEditionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition whereGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition wherePdfPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition whereTotalPages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperEdition whereUpdatedAt($value)
 */
	class EpaperEdition extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $edition_id
 * @property int $page_no
 * @property string $image_path
 * @property string $thumb_path
 * @property int|null $width
 * @property int|null $height
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EpaperEdition $edition
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EpaperRegion> $regions
 * @property-read int|null $regions_count
 * @method static \Database\Factories\EpaperPageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage whereEditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage wherePageNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage whereThumbPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperPage whereWidth($value)
 */
	class EpaperPage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $page_id
 * @property int|null $article_id
 * @property numeric $x
 * @property numeric $y
 * @property numeric $w
 * @property numeric $h
 * @property string|null $label
 * @property string|null $type
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EpaperArticle|null $article
 * @property-read \App\Models\EpaperPage $page
 * @method static \Database\Factories\EpaperRegionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereH($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereW($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EpaperRegion whereY($value)
 */
	class EpaperRegion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $imageable_type
 * @property int $imageable_id
 * @property string $path
 * @property string|null $caption
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ImageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Image whereUserId($value)
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\NewsCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereUpdatedAt($value)
 */
	class NewsCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string|null $image_path
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $views_count
 * @property int $likes_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NewsCategory> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VideoLink> $videoLinks
 * @property-read int|null $video_links_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post broadSearch(?string $term)
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post filtered($search = null, $status = null, $categoryId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereViewsCount($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\TagFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $mobile_number
 * @property int $user_role_id
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property numeric|null $location_lat
 * @property numeric|null $location_lng
 * @property string|null $session_token
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\UserRole $role
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLocationLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLocationLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSessionToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserRoleId($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereUpdatedAt($value)
 */
	class UserRole extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $videoable_type
 * @property int $videoable_id
 * @property string $link
 * @property string|null $caption
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $embed_link
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $videoable
 * @method static \Database\Factories\VideoLinkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink whereVideoableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VideoLink whereVideoableType($value)
 */
	class VideoLink extends \Eloquent {}
}

