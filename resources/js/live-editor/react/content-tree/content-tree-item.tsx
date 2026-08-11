import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { useAlertDialog } from "@narsil-ui/blocks/alert-dialog";
import { Tooltip } from "@narsil-ui/blocks/tooltip";
import { Button } from "@narsil-ui/components/button";
import { Icon } from "@narsil-ui/components/icon";
import { SortableHandle } from "@narsil-ui/components/sortable";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import type { ContentTreeNode } from "../../core/types";
import { useLiveEditor, useLiveEditorState } from "../live-editor-context";
import ContentTreeGroup from "./content-tree-group";

type ContentTreeItemProps = {
  node: ContentTreeNode;
};

function ContentTreeItem({ node }: ContentTreeItemProps) {
  const { trans } = useTranslator();
  const { setAlertDialog } = useAlertDialog();

  const editor = useLiveEditor();
  const { selectedNodeId } = useLiveEditorState();

  const {
    attributes,
    isDragging,
    listeners,
    transform,
    transition,
    setActivatorNodeRef,
    setNodeRef,
  } = useSortable({
    id: node.id,
  });

  const selected = selectedNodeId === node.id;

  return (
    <li
      ref={setNodeRef}
      className={cn("list-none", isDragging && "opacity-50")}
      style={{
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
    >
      <div
        className={cn(
          "group flex items-center gap-1 overflow-hidden rounded border pr-1",
          selected
            ? "border-primary bg-accent"
            : "border-transparent hover:bg-accent/50",
        )}
      >
        <SortableHandle
          ref={setActivatorNodeRef}
          className="h-8 w-5 shrink-0"
          isDragging={isDragging}
          {...attributes}
          {...listeners}
        />
        <button
          className="flex min-w-0 grow items-center gap-2 py-1.5 text-left text-sm"
          type="button"
          onClick={() => editor.selectNode(node.id)}
        >
          <Icon className="size-4 shrink-0" name="block" />
          <span className="truncate">{node.label}</span>
          {node.active === false ? (
            <Icon className="size-3.5 shrink-0" name="eye-off" />
          ) : null}
        </button>
        {node.meta.canDelete ? (
          <Tooltip tooltip={trans("ui.delete")}>
            <Button
              aria-label={trans("ui.delete")}
              className="shrink-0 opacity-0 group-hover:opacity-100"
              size="icon-sm"
              variant="ghost"
              onClick={() => {
                setAlertDialog({
                  title: trans("ui.delete"),
                  description: node.label ?? "",
                  actions: [
                    {
                      children: trans("ui.delete"),
                      onClick: () => editor.deleteNode(node.id),
                    },
                  ],
                });
              }}
            >
              <Icon name="trash" />
            </Button>
          </Tooltip>
        ) : null}
      </div>
      {node.children.length > 0 ? (
        <div className="mt-1 ml-3 border-l pl-2">
          {node.children.map((child) => {
            return <ContentTreeGroup node={child} key={child.id} />;
          })}
        </div>
      ) : null}
    </li>
  );
}

export default ContentTreeItem;
