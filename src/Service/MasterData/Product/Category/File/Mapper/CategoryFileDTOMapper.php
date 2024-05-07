<?php

namespace App\Service\MasterData\Product\Category\File\Mapper;

use App\Entity\Category;
use App\Entity\CategoryFile;
use App\Form\Common\File\Mapper\FileDTOMapper;
use App\Form\MasterData\Category\File\DTO\CategoryFileDTO;
use App\Repository\CategoryFileRepository;
use App\Repository\CategoryRepository;

class CategoryFileDTOMapper
{

    private CategoryRepository $categoryRepository;
    private FileDTOMapper $fileDTOMapper;
    private CategoryFileRepository $categoryFileRepository;

    public function __construct(CategoryRepository $categoryRepository, FileDTOMapper $fileDTOMapper, CategoryFileRepository $categoryFileRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->fileDTOMapper = $fileDTOMapper;
        $this->categoryFileRepository = $categoryFileRepository;
    }

    public function mapFormDtoToEntityForCreate(CategoryFileDTO $categoryFileDTO): CategoryFile
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findOneBy(['id' => $categoryFileDTO->categoryId]);
        $file = $this->fileDTOMapper->mapToFileEntityForCreate($categoryFileDTO->fileFormDTO);
        return $this->categoryFileRepository->create($file, $category);

    }
    public function mapFormDtoToEntityForEdit(CategoryFileDTO $categoryFileDTO,CategoryFile $categoryFile): CategoryFile
    {
       $file = $this->fileDTOMapper->mapToFileEntityForEdit($categoryFileDTO->fileFormDTO,$categoryFile->getFile());

       $categoryFile->setFile($file);

       return $categoryFile;

    }

    public function mapEntityToDto(CategoryFile $categoryFile): CategoryFileDTO
    {

        $dto = new CategoryFileDTO();
        $dto->categoryId = $categoryFile->getCategory()->getId();
        $dto->fileFormDTO = $this->fileDTOMapper->mapEntityToFileDto($categoryFile->getFile());

        return  $dto;

    }
}