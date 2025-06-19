<?php $this->load->view('schools/header'); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3>School Partners Management</h3>
                    <div class="mt-3">
                        <a href="<?php echo base_url('schools/add'); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New School
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form action="<?php echo base_url('schools'); ?>" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="Search schools..." value="<?php echo set_value('search', $search); ?>">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>School Name</th>
                                    <th>Contact Person</th>
                                    <th>Email</th>
                                    <th>Students</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($schools as $school): ?>
                                <tr>
                                    <td><?php echo $school->school_name; ?></td>
                                    <td><?php echo $school->contact_person; ?></td>
                                    <td><?php echo $school->email; ?></td>
                                    <td><?php echo $school->num_students; ?></td>
                                    <td>
                                        <span class="badge <?php echo $school->status === 'active' ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo ucfirst($school->status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('schools/edit/' . $school->id); ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo base_url('schools/delete/' . $school->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this school?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <?php echo $pagination; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('schools/footer'); ?>
