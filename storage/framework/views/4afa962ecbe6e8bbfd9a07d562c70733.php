<?php if($paginator->hasPages()): ?>
    <nav aria-label="Pagination Navigation" role="navigation">
        <div class="pagination-container">
            <ul class="pagination pagination-custom mb-0">
                
                <?php if($paginator->onFirstPage()): ?>
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>

                
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(is_string($element)): ?>
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link"><?php echo e($element); ?></span>
                        </li>
                    <?php endif; ?>

                    
                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link"><?php echo e($page); ?></span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if($paginator->hasMorePages()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>

<style>
.pagination-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination-custom {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    background: white;
}

.pagination-custom .page-item {
    margin: 0;
    border: none;
}

.pagination-custom .page-item:first-child .page-link {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
    border-left: 1px solid #065f46;
}

.pagination-custom .page-item:last-child .page-link {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
    border-right: 1px solid #065f46;
}

.pagination-custom .page-link {
    color: #065f46;
    background-color: #fff;
    border: 1px solid #065f46;
    border-left: none;
    padding: 10px 15px;
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 45px;
    height: 40px;
}

.pagination-custom .page-link:hover {
    background: linear-gradient(135deg, #065f46 0%, #064e3b 100%);
    color: white;
    border-color: #065f46;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(6, 95, 70, 0.3);
    z-index: 2;
    position: relative;
}

.pagination-custom .page-item.active .page-link {
    background: linear-gradient(135deg, #065f46 0%, #064e3b 100%);
    color: white;
    border-color: #065f46;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(6, 95, 70, 0.3);
    z-index: 1;
    position: relative;
}

.pagination-custom .page-item.disabled .page-link {
    color: #9ca3af;
    background-color: #f8f9fa;
    border-color: #dee2e6;
    cursor: not-allowed;
}

.pagination-custom .page-item.disabled .page-link:hover {
    background-color: #f8f9fa;
    color: #9ca3af;
    transform: none;
    box-shadow: none;
}

/* Responsive design */
@media (max-width: 576px) {
    .pagination-custom .page-link {
        padding: 8px 10px;
        min-width: 35px;
        height: 35px;
        font-size: 13px;
    }
    
    .pagination-custom .page-item:not(.active):not(:first-child):not(:last-child) {
        display: none;
    }
    
    .pagination-custom .page-item:nth-child(2),
    .pagination-custom .page-item:nth-last-child(2) {
        display: list-item;
    }
}
</style><?php /**PATH C:\laragon\www\e-lapak\resources\views/custom/pagination.blade.php ENDPATH**/ ?>