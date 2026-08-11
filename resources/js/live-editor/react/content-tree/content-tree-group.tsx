import {
  SortableContext,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import { Icon } from "@narsil-ui/components/icon";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import type { ContentTreeNode } from "../../core/types";
import { useLiveEditor } from "../live-editor-context";
import ContentTreeAdd from "./content-tree-add";
import ContentTreeItem from "./content-tree-item";

type ContentTreeGroupProps = {
  node: ContentTreeNode;
};

/**
 * A builder container. It is not selectable, it is where blocks are added and
 * the boundary a block can be dragged within.
 */
function ContentTreeGroup({ node }: ContentTreeGroupProps) {
  const { trans } = useTranslator();

  const editor = useLiveEditor();

  return (
    <div className="grid gap-1">
      <div className="flex items-center justify-between gap-1 pl-1">
        <div className="flex min-w-0 items-center gap-1.5 text-muted-foreground">
          <Icon className="size-3.5 shrink-0" name="layers" />
          <span className="truncate text-xs font-medium tracking-wide uppercase">
            {node.label}
          </span>
        </div>
        <ContentTreeAdd
          blocks={node.allowedBlocks ?? []}
          onAdd={(blockId) => editor.addBlock(node.id, blockId)}
        />
      </div>
      <SortableContext
        items={node.children.map((child) => child.id)}
        strategy={verticalListSortingStrategy}
      >
        <ul
          className={cn("grid gap-1", node.children.length === 0 && "hidden")}
        >
          {node.children.map((child) => {
            return <ContentTreeItem node={child} key={child.id} />;
          })}
        </ul>
      </SortableContext>
      {node.children.length === 0 ? (
        <p className="px-1 pb-1 text-xs text-muted-foreground italic">
          {trans("live_editor.tree.empty")}
        </p>
      ) : null}
    </div>
  );
}

export default ContentTreeGroup;
