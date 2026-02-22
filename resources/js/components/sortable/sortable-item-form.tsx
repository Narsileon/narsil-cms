import { type UniqueIdentifier } from "@dnd-kit/core";
import { Button } from "@narsil-ui/components/button";
import {
  DialogBackdrop,
  DialogBody,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogPopup,
  DialogPortal,
  DialogRoot,
  DialogTitle,
  DialogTrigger,
} from "@narsil-ui/components/dialog";
import { FormProvider, FormRoot, FormTabs } from "@narsil-ui/components/form";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import type { FormData } from "@narsil-ui/types";
import { get } from "lodash-es";
import { type ComponentProps, type ReactNode, useState } from "react";
import { type AnonymousItem } from ".";

type SortableItemFormProps = ComponentProps<typeof DialogTrigger> & {
  children: ReactNode;
  form: FormData;
  ids: UniqueIdentifier[];
  item?: Record<string, unknown>;
  optionValue: string;
  onItemChange: (value: AnonymousItem) => void;
};

function SortableItemForm({
  children,
  form,
  ids,
  item = {},
  optionValue,
  onItemChange,
  ...props
}: SortableItemFormProps) {
  const { trans } = useTranslator();

  const [data, setData] = useState<Record<string, unknown>>(item);
  const [error, setError] = useState<string | null>(null);

  const [open, setOpen] = useState<boolean>(false);

  function onOpenChange(open: boolean) {
    if (!open) {
      setData(item);
      setError(null);
    }

    setOpen(open);
  }

  return (
    <DialogRoot open={open} onOpenChange={onOpenChange}>
      <Tooltip tooltip={trans("ui.edit")}>
        <DialogTrigger {...props} />
      </Tooltip>
      <DialogPortal>
        <DialogBackdrop />
        <DialogPopup>
          <DialogHeader className="border-b">
            <DialogTitle>{data?.handle as string}</DialogTitle>
          </DialogHeader>

          <FormProvider
            id={form.id}
            action={form.action}
            steps={form.steps}
            method={form.method}
            initialData={data}
            languages={form.languages}
            render={({ data }) => {
              return (
                <>
                  <DialogBody className={cn(form.steps.length > 1 && "p-0")}>
                    <DialogDescription className="sr-only" />
                    <FormRoot className="grid-cols-12 gap-4">
                      <FormTabs steps={form.steps} />
                    </FormRoot>
                  </DialogBody>
                  <DialogFooter className="border-t">
                    <Button variant="ghost" onClick={() => onOpenChange(false)}>
                      {trans("ui.cancel")}
                    </Button>
                    <Button
                      onClick={() => {
                        const oldUniqueIdentifier = get(
                          item,
                          optionValue ?? "value",
                        ) as UniqueIdentifier;
                        const newUniqueIdentifier = get(
                          data,
                          optionValue ?? "value",
                        ) as UniqueIdentifier;

                        if (oldUniqueIdentifier !== newUniqueIdentifier) {
                          if (ids.includes(newUniqueIdentifier)) {
                            setError(trans("validation.unique"));

                            return;
                          }
                        }

                        onItemChange(data as AnonymousItem);

                        onOpenChange(false);
                      }}
                    >
                      {trans("ui.save")}
                    </Button>
                  </DialogFooter>
                </>
              );
            }}
          />
        </DialogPopup>
      </DialogPortal>
    </DialogRoot>
  );
}

export default SortableItemForm;
