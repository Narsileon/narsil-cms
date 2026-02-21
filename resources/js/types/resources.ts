import { type InertiaLinkProps } from "@inertiajs/react";
import type { TemplateTab } from "@narsil-cms/types";
import { type IconName } from "@narsil-ui/registries/icons";
import { RoutesData } from "@narsil-ui/types";
import { type RowData } from "@tanstack/react-table";

declare module "@tanstack/react-table" {
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  interface ColumnMeta<TData extends RowData, TValue> {
    className?: string;
    type?: string;
  }
}

export type FormType = {
  action: string;
  autoSave: boolean;
  defaultLanguage: string;
  description: string;
  id: string;
  languageOptions: SelectOption[];
  method: string;
  routes: RoutesData;
  submitIcon?: IconName;
  submitLabel: string;
  tabs: TemplateTab[];
  title: string;
};

export type GroupedSelectOption = {
  [key: string]: unknown;
  icon?: IconName;
  identifier: string;
  label: string | Record<string, string>;
  optionLabel: string;
  options: (GroupedSelectOption | SelectOption)[];
  optionValue: string;
  routes: RoutesData;
  value: unknown;
};

export type MenuItem = {
  group?: string;
  icon?: IconName;
  label: string;
  method: InertiaLinkProps["method"];
  modal?: boolean;
  parameters?: Record<string, unknown>;
  route: string;
  target?: string;
};

export type Revision = {
  id: number;
  revision: number;
  uuid: string;
};

export type SelectOption = {
  [key: string]: unknown;
  icon?: IconName;
  label: string | Record<string, string>;
  value: UniqueIdentifier;
};

export type UniqueIdentifier = string | number;
