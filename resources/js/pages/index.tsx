import { flatNestedTree } from "@narsil-cms/lib/sortable";
import { SortableGrid, SortableTree } from "@narsil-cms/components/ui/sortable";
import { useState } from "react";

function Index() {
  const data = [
    { id: "A", parent_id: null, type: "section", children: [] },
    {
      id: "B",
      parent_id: null,
      type: "section",
      children: [
        { id: "B1", parent_id: "B", type: "item", children: [] },
        {
          id: "B2",
          parent_id: "B",
          type: "item",
          children: [
            { id: "B2a", parent_id: "B2", type: "item", children: [] },
            { id: "B2b", parent_id: "B2", type: "item", children: [] },
          ],
        },
      ],
    },
    { id: "C", parent_id: null, type: "section", children: [] },
    {
      id: "D",
      parent_id: null,
      type: "section",
      children: [
        { id: "D1", parent_id: "D", type: "item", children: [] },
        { id: "D2", parent_id: "D", type: "item", children: [] },
      ],
    },
    { id: "E", parent_id: null, type: "section", children: [] },
    { id: "F", parent_id: null, type: "section", children: [] },
  ];

  const [items, setItems] = useState(flatNestedTree(data));

  return (
    <div>
      <SortableTree items={items} setItems={setItems} />
      <SortableGrid />
    </div>
  );
}

export default Index;
