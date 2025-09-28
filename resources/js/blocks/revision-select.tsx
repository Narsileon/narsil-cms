import {
  SelectContent,
  SelectItem,
  SelectItemIndicator,
  SelectItemText,
  SelectPortal,
  SelectRoot,
  SelectScrollDownButton,
  SelectScrollUpButton,
  SelectTrigger,
  SelectValue,
  SelectViewport,
} from "@narsil-cms/components/select";
import type { Revision } from "@narsil-cms/types";
import { router } from "@inertiajs/react";

type RevisionSelectProps = {
  revisions: Revision[];
};

function RevisionSelect({ revisions }: RevisionSelectProps) {
  const params = new URLSearchParams(window.location.search);
  const revision = params.get("revision") ?? revisions[0]?.uuid;

  function onValueChange(value: string) {
    router.reload({ data: { revision: value } });
  }

  return (
    <SelectRoot value={revision} onValueChange={onValueChange}>
      <SelectTrigger className="bg-secondary" size={"sm"}>
        <SelectValue />
      </SelectTrigger>
      <SelectPortal>
        <SelectContent>
          <SelectScrollUpButton />
          <SelectViewport>
            {revisions?.map((revision) => (
              <SelectItem value={revision.uuid} key={revision.uuid}>
                <SelectItemIndicator />
                <SelectItemText>Revision {revision.revision}</SelectItemText>
              </SelectItem>
            ))}
          </SelectViewport>
          <SelectScrollDownButton />
        </SelectContent>
      </SelectPortal>
    </SelectRoot>
  );
}

export default RevisionSelect;
