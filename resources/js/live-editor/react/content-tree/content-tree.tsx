import {
  closestCenter,
  DndContext,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
  useSensor,
  useSensors,
  type DragEndEvent,
} from "@dnd-kit/core";
import { arrayMove } from "@dnd-kit/sortable";
import { useTranslator } from "@narsil-ui/components/translator";
import { flattenTree } from "../../core/tree-utils";
import { useLiveEditor, useLiveEditorState } from "../live-editor-context";
import ContentTreeGroup from "./content-tree-group";
import ContentTreeItem from "./content-tree-item";

function ContentTree() {
  const { trans } = useTranslator();

  const editor = useLiveEditor();
  const { tree } = useLiveEditorState();

  const sensors = useSensors(
    useSensor(MouseSensor),
    useSensor(TouchSensor),
    useSensor(KeyboardSensor),
  );

  function onDragEnd({ active, over }: DragEndEvent) {
    if (!over || active.id === over.id) {
      return;
    }

    const nodes = flattenTree(tree);

    const activeNode = nodes.find((node) => node.id === active.id);
    const overNode = nodes.find((node) => node.id === over.id);

    // Blocks only move inside the builder they belong to; moving one across
    // builders would change its schema.
    if (
      !activeNode?.parent_id ||
      activeNode.parent_id !== overNode?.parent_id
    ) {
      return;
    }

    const parent = nodes.find((node) => node.id === activeNode.parent_id);

    if (!parent) {
      return;
    }

    const uuids = parent.children.map((child) => child.id);

    const from = uuids.indexOf(String(active.id));
    const to = uuids.indexOf(String(over.id));

    if (from === -1 || to === -1) {
      return;
    }

    editor.reorderNodes(parent.id, arrayMove(uuids, from, to));
  }

  if (tree.length === 0) {
    return (
      <p className="p-4 text-sm text-muted-foreground">
        {trans("live_editor.tree.empty")}
      </p>
    );
  }

  return (
    <DndContext
      sensors={sensors}
      collisionDetection={closestCenter}
      onDragEnd={onDragEnd}
    >
      <div className="grid gap-3 p-3">
        {tree.map((node) => {
          return node.type === "builder" ? (
            <ContentTreeGroup node={node} key={node.id} />
          ) : (
            <ul className="grid gap-1" key={node.id}>
              <ContentTreeItem node={node} />
            </ul>
          );
        })}
      </div>
    </DndContext>
  );
}

export default ContentTree;
