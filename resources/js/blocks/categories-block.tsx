import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/react";
import { ModalLink } from "@/components/ui/modal";
import { route } from "ziggy-js";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import {
  DeleteIcon,
  EditIcon,
  MoreHorizontalIcon,
  PlusIcon,
} from "lucide-react";
import type { CategoriesCollection } from "@/types/global";

type CategoriesBlockProps = React.ComponentProps<typeof Section> &
  CategoriesCollection & {};

function CategoriesBlock({ data, meta, ...props }: CategoriesBlockProps) {
  const { getLabel } = useLabels();

  return (
    <Section {...props}>
      <SectionHeader className="flex items-center justify-between gap-4">
        <SectionTitle level="h2">{meta.title}</SectionTitle>
        {meta.routes.create ? (
          <Tooltip tooltip={getLabel("ui.create")}>
            <Button asChild={true} size="icon">
              <ModalLink href={route(meta.routes.create)}>
                <PlusIcon />
              </ModalLink>
            </Button>
          </Tooltip>
        ) : null}
      </SectionHeader>
      <SectionContent>
        <ul className="grid gap-2">
          {data.map((category) => (
            <li
              className="flex items-center justify-between gap-2"
              key={category.id}
            >
              <Button className="grow justify-start" variant="ghost">
                {category.label}
              </Button>
              <DropdownMenu>
                <DropdownMenuTrigger asChild>
                  <Button size="icon" variant="ghost">
                    <MoreHorizontalIcon className="h-4 w-4" />
                  </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                  {meta.routes.edit ? (
                    <DropdownMenuItem asChild={true}>
                      <ModalLink href={route(meta.routes.edit, category.id)}>
                        <EditIcon />
                        {getLabel("ui.edit")}
                      </ModalLink>
                    </DropdownMenuItem>
                  ) : null}
                  <DropdownMenuSeparator />
                  {meta.routes.destroy ? (
                    <DropdownMenuItem asChild={true}>
                      <Link
                        as="button"
                        href={route(meta.routes.destroy, category.id)}
                        method="delete"
                        data={{
                          _back: true,
                        }}
                      >
                        <DeleteIcon />
                        {getLabel("ui.delete")}
                      </Link>
                    </DropdownMenuItem>
                  ) : null}
                </DropdownMenuContent>
              </DropdownMenu>
            </li>
          ))}
        </ul>
      </SectionContent>
    </Section>
  );
}

export default CategoriesBlock;
