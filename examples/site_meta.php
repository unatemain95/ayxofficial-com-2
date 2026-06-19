<?php
/**
 * Site meta information handler
 * Provides structured site metadata and description generation
 */
class SiteMeta {
    private array $meta = [];
    
    public function __construct(array $config = []) {
        $this->meta = $config;
    }
    
    public static function fromDefaults(): self {
        return new self([
            'name' => '爱游戏官方',
            'url' => 'https://ayxofficial.com',
            'description' => '爱游戏官方平台提供丰富的游戏选择与优质服务',
            'keywords' => ['爱游戏', '游戏平台', '官方'],
            'language' => 'zh-CN',
            'version' => '2.1.0'
        ]);
    }
    
    public function setMeta(string $key, $value): void {
        $this->meta[$key] = $value;
    }
    
    public function getMeta(string $key) {
        return $this->meta[$key] ?? null;
    }
    
    public function generateShortDescription(int $maxLength = 120): string {
        $parts = [];
        
        $name = $this->getMeta('name');
        $desc = $this->getMeta('description');
        $keywords = $this->getMeta('keywords');
        
        if ($name) {
            $parts[] = $name;
        }
        
        if ($desc) {
            $parts[] = $desc;
        }
        
        if (!empty($keywords)) {
            $kwStr = implode('、', $keywords);
            $parts[] = "关键词: {$kwStr}";
        }
        
        $text = implode(' - ', $parts);
        
        if (mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength) . '...';
        }
        
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
    
    public function toArray(): array {
        return $this->meta;
    }
    
    public function toJson(): string {
        return json_encode($this->meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

// --- Example usage ---

$site = SiteMeta::fromDefaults();

// Customize additional fields
$site->setMeta('author', 'AYX Team');
$site->setMeta('year', 2025);
$site->setMeta('shortDesc', $site->generateShortDescription(100));

echo "Site Name: " . $site->getMeta('name') . "\n";
echo "URL: " . $site->getMeta('url') . "\n";
echo "Description: " . $site->generateShortDescription() . "\n";
echo "\nFull metadata:\n";
echo $site->toJson() . "\n";

// Another instance with custom data
$customSite = new SiteMeta([
    'name' => '爱游戏娱乐',
    'url' => 'https://ayxofficial.com/games',
    'description' => '探索爱游戏热门游戏与最新活动',
    'keywords' => ['爱游戏', '热门游戏', '活动'],
    'language' => 'zh-CN',
]);

echo "\nCustom site description:\n";
echo $customSite->generateShortDescription(80) . "\n";