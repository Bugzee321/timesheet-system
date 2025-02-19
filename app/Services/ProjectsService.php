<?php

namespace App\Services;

use App\Models\Project;

class ProjectsService
{
    /**
     * List projects with pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listProjectsPaginated(array $filters = [], int $perPage = 10)
    {
        return Project::filter($filters)->paginate($perPage);
    }

    /**
     * Create a new project.
     *
     * @param array $data
     * @return \App\Models\Project
     */
    public function createProject(array $data)
    {
        $project = Project::create($data);
        if (isset($data['attributes']) && is_array($data['attributes'])) {
            foreach ($data['attributes'] as $attribute) {
                $project->attributeValues()->create([
                    'attribute_id' => $attribute['id'],
                    'value' => $attribute['value'],
                ]);
            }
        }
        return $project;
    }

    /**
     * Update the specified project.
     *
     * @param \App\Models\Project $project
     * @param array $data
     * @return \App\Models\Project
     */
    public function updateProject(Project $project, array $data)
    {
        $project->update($data);
        if (isset($data['attributes']) && is_array($data['attributes'])) {
            foreach ($data['attributes'] as $attribute) {
                $project->attributeValues()->updateOrCreate([
                    'attribute_id' => $attribute['id'],
                ], [
                    'value' => $attribute['value'],
                ]); 
            }
        }
        return $project;
    }

    /**
     * Delete the specified project.
     *
     * @param Project $project
     * @return bool|null
     */
    public function deleteProject(Project $project): ?bool
    {
        return $project->delete();
    }
}
