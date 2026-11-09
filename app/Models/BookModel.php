<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'category_id',
        'code',
        'title',
        'author',
        'publisher',
        'published_year',
        'stock_total',
        'stock_available',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';

    public function getBooksWithCategory(string $title = '', ?int $categoryId = null, bool $activeOnly = false): array
    {
        $query = $this->select('books.*, categories.name AS category_name')
            ->join('categories', 'categories.id = books.category_id')
            ->orderBy('books.title', 'ASC')
            ->orderBy('books.id', 'ASC');

        if ($title !== '') {
            $query->like('books.title', $title);
        }

        if ($categoryId !== null) {
            $query->where('books.category_id', $categoryId);
        }

        if ($activeOnly) {
            $query->where('books.is_active', 1);
        }

        return $query->findAll();
    }

    public function getBookWithCategory(int $id): ?array
    {
        return $this->select('books.*, categories.name AS category_name, categories.description AS category_description')
            ->join('categories', 'categories.id = books.category_id')
            ->where('books.id', $id)
            ->first();
    }

    public function getStatistics(): array
    {
        return db_connect()->table($this->table)
            ->selectCount('id', 'total_books')
            ->selectSum('stock_available', 'available_copies')
            ->get()
            ->getRowArray();
    }

    public function getLoanHistory(int $bookId): array
    {
        return db_connect()->table('loan_details')
            ->select([
                'loan_details.id',
                'loan_details.quantity',
                'loans.loan_code',
                'loans.loan_date',
                'loans.due_date',
                'loans.status',
                'members.member_code',
                'members.name AS member_name',
            ])
            ->select('COALESCE(SUM(loan_returns.quantity), 0) AS quantity_returned', false)
            ->join('loans', 'loans.id = loan_details.loan_id')
            ->join('members', 'members.id = loans.member_id')
            ->join('loan_returns', 'loan_returns.loan_detail_id = loan_details.id', 'left')
            ->where('loan_details.book_id', $bookId)
            ->groupBy([
                'loan_details.id',
                'loan_details.quantity',
                'loans.loan_code',
                'loans.loan_date',
                'loans.due_date',
                'loans.status',
                'members.member_code',
                'members.name',
            ])
            ->orderBy('loans.loan_date', 'DESC')
            ->orderBy('loans.id', 'DESC')
            ->get()
            ->getResultArray();
    }
}